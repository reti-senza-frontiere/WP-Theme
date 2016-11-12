<?php


class RegisterUser {
    public static function get_data($data, $wpdb) {
        self::$wpdb = $wpdb;
        // print_r($_POST);
        self::$registration_form = $data["registration_form"];
        self::$personal_data = $registration_form["personal_data"];
        self::$residency = $registration_form["residency"];
        self::$documents = $registration_form["documents"];
        self::$contacts = $registration_form["contacts"];
        self::$extra = $registration_form["extra"];
        self::$survey = self::$extra["survey"];
    }

    private static function user_ip_address() {
        return $_SERVER["REMOTE_ADDR"];
    }
    private static function user_agent() {
        return $_SERVER["HTTP_USER_AGENT"];
    }

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
            $survey_id = $wpdb->insert_id;
        } else {
            $survey_id = null;
        }
        return $survey_id;
    }

    /**
     * Save data in the database
     */
    private static function save_posts() {
        $results = self::$wpdb->insert(
            "rsf_memebers",
            array(
                // Personal data
                "name"          => self::$personal_data["name"],
                "last_name"     => self::$personal_data["last_name"],
                "birth_date"    => date("Y-m-d", strtotime(str_replace("/", "-", self::$personal_data["birth_date"]))),
                "birth_place"   => self::$personal_data["birth_place"],
                "company"       => self::$personal_data["company"],
                "vat_number"    => self::$personal_data["vat_number"],
                // Residency
                "residency_search_map"  => self::$residency["search_map"],
                "residency_map_data"    => self::$residency["map_data"],
                "residency_street"      => self::$residency["street"],
                "residency_street_no"   => self::$residency["street_no"],
                "residency_city"        => self::$residency["city"],
                "residency_postal_code" => self::$residency["postal_code"],
                "residency_province"    => self::$residency["province"],
                "residency_region"      => self::$residency["region"],
                "residency_city"        => self::$residency["city"],
                // Documents
                "documents_fiscal_code"         => self::$documents["fiscal_code"],
                "documents_identity_document"   => self::$documents["identity_document"],
                "documents_released_by"         => self::$documents["released_by"],
                "documents_released_date"       => date("Y-m-d", strtotime(str_replace("/", "-", self::$documents["released_date"]))),
                // Contacts
                "contacts_telephone_number" => self::$contacts["telephone_number"],
                "contacts_cellular_number"  => self::$contacts["cellular_number"],
                "contacts_email_address"    => self::$contacts["email_address"],
                // Survey ID
                "survey" => self::save_survey(),
                // The user wants to donate
                "declared_donation" => self::$extra["declared_donation"],
                // The user wants to be part of the Net
                "extra_requires_to_be_part_of_the_net" => ((self::$extra["net_membership_requested"] == "on") ? true : false),
                // Privacy
                "privacy_agree" => ((self::$extra["privacy"]["agree"] == "on") ? true : false),
                "privacy_allow" => ((self::$extra["privacy"]["allow"] == "on") ? true : false),
                // User data
                "user_ip" => self::user_ip_address(),
                "user_agent" => self::user_agent()
            )
        );
        if($result !== false) {
            // Send the email
            self::send_mail_to_user();
        } else {
            // There was an error
            // redirect the user to the error page
            // wp_redirect( get_site_url() . "/errore");
        }
    }

    private static function send_mail_to_user() {
        require("../lib/packs/vendor/phpmailer/phpmailer/PHPMailerAutoload.php");
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = "smtp1.retisenzafrontiere.org";
        $mail->SMTPAuth = true;
        $mail->Username = "noreply@retisenzafrontiere.org";
        $mail->Password = "secret";
        $mail->SMTPSecure = "tls";
        $mail->Port = 587;
        $mail->setFrom("noreply@retisenzafrontiere.org", "Reti Senza Frontiere");
        $mail->addAddress(self::$contacts["email_address"], self::$personal_data["name"] . " " . self::$personal_data["last_name"]);
        $mail->addReplyTo("info@retisenzafrontiere.org", "Reti Senza Frontiere");

        $mail->addAttachment(self::generate_receipt(), "ricevuta_registrazione.jpg");
        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = "Registrazione a Reti Senza Frontiere";
        // $mail->Body    = "This is the HTML message body <b>in bold!</b>";
        // $mail->AltBody = "This is the body in plain text for non-HTML mail clients";
    }

    /**
     * Generate the receipt pdf file
     * @return string                                                           The file path
     */
    private static function generate_receipt() {

    }

    public static function run($data, $wpdb) {
        self::get_data($data, $wpdb);
        self::save_posts();
    }
}

?>
