<?php
require_once("wp-content/themes/RetiSenzaFrontiere/lib/packs/vendor/autoload.php");

class RegisterUser {
    static private $wpdb;
    static private $registration_form;
    static private $personal_data;
    static private $residency;
    static private $documents;
    static private $contacts;
    static private $extra;
    static private $survey;
    static private $mail;

    public static function get_data($data, $wpdb) {

        self::$wpdb = $wpdb;
        // print_r($_POST);
        self::$registration_form = $data["registration_form"];
        self::$personal_data = self::$registration_form["personal_data"];
        self::$residency = self::$registration_form["residency"];
        self::$documents = self::$registration_form["documents"];
        self::$contacts = self::$registration_form["contacts"];
        self::$extra = self::$registration_form["extra"];
        self::$survey = self::$extra["survey"];

        $mail_config = parse_ini_file("wp-content/themes/RetiSenzaFrontiere/configs/mail.ini");
        self::$mail = new PHPMailer;
        self::$mail->isSMTP();
        self::$mail->Host = $mail_config["host"];
        self::$mail->SMTPAuth = $mail_config["auth"];
        self::$mail->Username = $mail_config["user"];
        self::$mail->Password = $mail_config["pass"];
        self::$mail->SMTPSecure = $mail_config["connection_type"];
        self::$mail->Port = $mail_config["port"];
        self::$mail->setFrom($mail_config["from"]["address"], $mail_config["from"]["name"]);
        self::$mail->addAttachment(self::generate_receipt(), "ricevuta_registrazione_" . self::receipt_id() . "-" . date("Y-m-d") . ".pdf");
    }

    /**
     * The user IPv4 address
     * @return string                                                           The user IPv4 address in 15 characters length string format
     */
    private static function user_ip_address() {
        return $_SERVER["REMOTE_ADDR"];
    }

    /**
     * The user agent
     * @return string                                                           The user agent
     */
    private static function user_agent() {
        return $_SERVER["HTTP_USER_AGENT"];
    }

    /**
     * Generate the receipt ID
     * @return string                                                           The receipt ID based on user agent and IPv4 address
     */
    private static function receipt_id() {
        return md5(self::user_ip_address() . "~" . self::user_agent());
    }

    /**
     * Save the survey data
     * @return int|null                                                         The saved survey last ID
     */
    private static function save_survey() {
        if((isset(self::$survey) && count(self::$survey) > 0)) {
            $result = self::$wpdb->insert(
                "rsf_surveys",
                array(
                    "reg_request_id"    => self::receipt_id(),
                    "no_connectivity"   => (isset(self::$survey["no_connectivity"]) && (self::$survey["no_connectivity"] == "on") ? true : false),
                    "only_tethering"    => (isset(self::$survey["only_tethering"]) && (self::$survey["only_tethering"] == "on") ? true : false),
                    "only_tethering"    => (isset(self::$survey["only_tethering"]) && (self::$survey["only_tethering"] == "on") ? true : false),
                    "low_connectivity"  => (isset(self::$survey["low_connectivity"]) && (self::$survey["low_connectivity"] == "on") ? true : false),
                    "too_expensive"     => (isset(self::$survey["too_expensive"]) && (self::$survey["too_expensive"] == "on") ? true : false),
                    "no_satisfied"      => (isset(self::$survey["no_satisfied"]) && (self::$survey["no_satisfied"] == "on") ? true : false),
                    "other"             => self::$survey["other"]["reason"],
                )
            );
            $survey_id = self::$wpdb->insert_id;
        } else {
            $survey_id = null;
        }
        return $survey_id;
    }

    /**
     * Save data in the database
     */
    private static function save_posts() {
        try {
            $db_config = parse_ini_file("wp-content/themes/RetiSenzaFrontiere/configs/database.ini");
            $dbh = new PDO("mysql:host=" . $db_config["host"] . ";dbname=rsf_data", $db_config["user"], $db_config["pass"]);
            // $results = self::$wpdb->insert(
            //     "rsf_memebers",
            //     array(
            //         // Personal data
            //         "name"          => self::$personal_data["name"],
            //         "last_name"     => self::$personal_data["last_name"],
            //         "birth_date"    => date("Y-m-d", strtotime(str_replace("/", "-", self::$personal_data["birth_date"]))),
            //         "birth_place"   => self::$personal_data["birth_place"],
            //         "company"       => self::$personal_data["company"],
            //         "vat_number"    => self::$personal_data["vat_number"],
            //         // Residency
            //         "residency_search_map"  => self::$residency["search_map"],
            //         "residency_map_data"    => self::$residency["map_data"],
            //         "residency_street"      => self::$residency["street"],
            //         "residency_street_no"   => self::$residency["street_no"],
            //         "residency_city"        => self::$residency["city"],
            //         "residency_postal_code" => self::$residency["postal_code"],
            //         "residency_province"    => self::$residency["province"],
            //         "residency_region"      => self::$residency["region"],
            //         "residency_city"        => self::$residency["city"],
            //         // Documents
            //         "documents_fiscal_code"         => self::$documents["fiscal_code"],
            //         "documents_identity_document"   => self::$documents["identity_document"],
            //         "documents_released_by"         => self::$documents["released_by"],
            //         "documents_released_date"       => date("Y-m-d", strtotime(str_replace("/", "-", self::$documents["released_date"]))),
            //         // Contacts
            //         "contacts_telephone_number" => self::$contacts["telephone_number"],
            //         "contacts_cellular_number"  => self::$contacts["cellular_number"],
            //         "contacts_email_address"    => self::$contacts["email_address"],
            //         // Survey ID
            //         "survey" => self::save_survey(),
            //         // The user wants to donate
            //         "declared_donation" => self::$extra["declared_donation"],
            //         // The user wants to be part of the Net
            //         "extra_requires_to_be_part_of_the_net" => ((self::$extra["net_membership_requested"] == "on") ? true : false),
            //         // Privacy
            //         "privacy_agree" => ((self::$extra["privacy"]["agree"] == "on") ? true : false),
            //         "privacy_allow" => ((self::$extra["privacy"]["allow"] == "on") ? true : false),
            //         // User data
            //         "user_ip" => self::user_ip_address(),
            //         "user_agent" => self::user_agent()
            //     )
            // );
            if($results !== false) {
                // Send the email
                self::send_mail_to_user();
                self::send_mail_to_admin();
                // wp_redirect( get_site_url() . "/associazione/moduli/modulo-di-registrazione-soci-sostenitori/registrazione-avvenuta-con-successo" );
            } else {
                // There was an error
                // redirect the user to the error page
                // wp_redirect( get_site_url() . "/errore");
            }
        } catch(PDOException $e) {
            // There was an error
            // redirect the user to the error page
            // wp_redirect( get_site_url() . "/errore");
        }
    }

    // Send the email to the user
    private static function send_mail_to_user() {
        self::$mail->addAddress(self::$contacts["email_address"], self::$personal_data["name"] . " " . self::$personal_data["last_name"]);
        self::$mail->addReplyTo("info@retisenzafrontiere.org", "Reti Senza Frontiere");
        self::$mail->WordWrap = 50;
        self::$mail->isHTML(false);                                  // Set email format to HTML

        self::$mail->Subject = "Registrazione a Reti Senza Frontiere";
        self::$mail->Body    = "Test";
        // self::$mail->AltBody = "This is the body in plain text for non-HTML mail clients";
        if(!self::$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . self::$mail->ErrorInfo;
        } else {
            echo 'Message has been sent';
        }
    }

    private static function send_mail_to_admin() {
        self::$mail->ClearAllRecipents();
        self::$mail->addAddress("registrazioni@retisenzafrontiere.org", "Reti Senza Frontiere");
        self::$mail->isHTML(false);
        self::$mail->WordWrap = 50;

        self::$mail->Subject = "Registrazione dal sito";
        self::$mail->Body    = "Test";
        // self::$mail->AltBody = "This is the body in plain text for non-HTML mail clients";
        if(!self::$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . self::$mail->ErrorInfo;
        } else {
            echo 'Message has been sent';
        }
    }

    /**
     * Generate the receipt pdf file
     * @return string                                                           The file path
     */
    private static function generate_receipt() {
        $filename = "documents/ricevuta_registrazione_" . self::receipt_id() . "-" . date("Y-m-d") . ".pdf";
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',16);
        $pdf->Cell(40,10,'Hello World!');
        // $pdf->Output("D");
        $pdf->Output("F", $filename);
        return $filename;
    }

    public static function run($data, $wpdb) {
        self::get_data($data, $wpdb);
        self::save_posts();
    }
}

?>
