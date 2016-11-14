<?php
require_once("wp-content/themes/RetiSenzaFrontiere/lib/packs/vendor/autoload.php");
define("EURO", chr(128));

class RegisterUser {
    static private $wpdb;
    static private $registration_form;
    static private $personal_data;
    static private $residency;
    static private $documents;
    static private $contacts;
    static private $extra;
    static private $survey;
    static private $db_config;
    static private $mail_config;
    static private $mail;

    public static function get_data($data) {
        // print_r($_POST);
        self::$registration_form = $data["registration_form"];
        self::$personal_data = self::$registration_form["personal_data"];
        self::$residency = self::$registration_form["residency"];
        self::$documents = self::$registration_form["documents"];
        self::$contacts = self::$registration_form["contacts"];
        self::$extra = self::$registration_form["extra"];
        self::$survey = self::$extra["survey"];

        self::$db_config = parse_ini_file("wp-content/themes/RetiSenzaFrontiere/configs/database.ini");
        self::$mail_config = parse_ini_file("wp-content/themes/RetiSenzaFrontiere/configs/mail.ini");
        self::$mail = new PHPMailer;
        self::$mail->isSMTP();
        self::$mail->ContentType = "text/plain";
        self::$mail->Encoding = "quoted-printable";
        self::$mail->charSet = "UTF-8";
        self::$mail->isHTML(false);
        // self::$mail->WordWrap = 50;
        self::$mail->Host = self::$mail_config["host"];
        self::$mail->SMTPAuth = self::$mail_config["auth"];
        self::$mail->Username = self::$mail_config["user"];
        self::$mail->Password = self::$mail_config["pass"];
        self::$mail->SMTPSecure = self::$mail_config["connection_type"];
        self::$mail->Port = self::$mail_config["port"];
        self::$mail->setFrom(self::$mail_config["from"]["address"], self::$mail_config["from"]["name"]);
        self::$mail->addAttachment(self::generate_receipt(), "ricevuta_registrazione_" . self::receipt_id() . "-" . date("Y-m-d") . ".pdf");
    }

    /**
     * Detect gender from given name
     * @param  string                   $name                                   A name
     * @return bool                                                             If is male return true otherwise false;
     */
    public static function is_male($name) {
        $recognizer = new \Genderize\Base\Recognizer($name);
        return $recognizer->set_country_id("it")->recognize()->is_male();
    }

    public static function run($data) {
        self::get_data($data);
        self::save_posts();
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
            $pdo = new PDO("mysql:host=" . self::$db_config["host"] . ";dbname=rsf_data", self::$db_config["user"], self::$db_config["pass"]);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO rsf_surveys(`" . implode("`, `", self::$db_config["rsf_surveys_cols"]) . "`) VALUES (:" . implode(", :", self::$db_config["rsf_surveys_cols"]) . ")";
            $stmt = $pdo->prepare($sql);

            $receipt_id = self::receipt_id();
            $no_connectivity = (isset(self::$survey["no_connectivity"]) && (self::$survey["no_connectivity"] == "on") ? 1 : 0);
            $only_tethering = (isset(self::$survey["only_tethering"]) && (self::$survey["only_tethering"] == "on") ? 1 : 0);
            $low_connectivity = (isset(self::$survey["low_connectivity"]) && (self::$survey["low_connectivity"] == "on") ? 1 : 0);
            $too_expensive = (isset(self::$survey["too_expensive"]) && (self::$survey["too_expensive"] == "on") ? 1 : 0);
            $no_satisfied = (isset(self::$survey["no_satisfied"]) && (self::$survey["no_satisfied"] == "on") ? 1 : 0);

            $stmt->bindParam(":reg_request_id", self::$personal_data["name"], PDO::PARAM_STR);
            $stmt->bindParam("reg_request_id", $receipt_id, PDO::PARAM_STR);
            $stmt->bindParam("no_connectivity", $no_connectivity, PDO::PARAM_STR);
            $stmt->bindParam("only_tethering", $only_tethering, PDO::PARAM_STR);
            $stmt->bindParam("low_connectivity", $low_connectivity, PDO::PARAM_STR);
            $stmt->bindParam("too_expensive", $too_expensive, PDO::PARAM_STR);
            $stmt->bindParam("no_satisfied", $no_satisfied, PDO::PARAM_STR);
            $stmt->bindParam("other", self::$survey["other"]["reason"]);

            $stmt->execute();
            $survey_id = $pdo->lastInsertId();
        } else {
            $survey_id = null;
        }
        return $survey_id;
    }

    /**
     * Save data in the database
     */
    private static function save_posts() {
        /**
         * Try to insert data in the database
         */
        try {
            $pdo = new PDO("mysql:host=" . self::$db_config["host"] . ";dbname=rsf_data", self::$db_config["user"], self::$db_config["pass"]);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO rsf_members(`" . implode("`, `", self::$db_config["rsf_members_cols"]) . "`) VALUES (:" . implode(", :", self::$db_config["rsf_members_cols"]) . ")";
            $stmt = $pdo->prepare($sql);

            $birth_date = date("Y-m-d", strtotime(str_replace("/", "-", self::$personal_data["birth_date"])));
            $documents_released_date = date("Y-m-d", strtotime(str_replace("/", "-", self::$documents["released_date"])));
            $survey_id = self::save_survey();
            $membership_requested = ((self::$extra["net_membership_requested"] == "on") ? 1 : 0);
            $privacy_agree = ((self::$extra["privacy"]["agree"] == "on") ? 1 : 0);
            $privacy_allow = ((self::$extra["privacy"]["allow"] == "on") ? 1 : 0);
            $user_ip_address = self::user_ip_address();
            $user_agent = self::user_agent();

            // Personal data
            $stmt->bindParam(":name", self::$personal_data["name"], PDO::PARAM_STR);
            $stmt->bindParam(":last_name", self::$personal_data["last_name"], PDO::PARAM_STR);
            $stmt->bindParam(":birth_date", $birth_date, PDO::PARAM_STR);
            $stmt->bindParam(":birth_place", self::$personal_data["birth_place"], PDO::PARAM_STR);
            $stmt->bindParam(":company", self::$personal_data["company"], PDO::PARAM_STR);
            $stmt->bindParam(":vat_number", self::$personal_data["vat_number"], PDO::PARAM_STR);
            // Residency
            $stmt->bindParam(":residency_search_map", self::$residency["search_map"], PDO::PARAM_STR);
            $stmt->bindParam(":residency_map_data", self::$residency["map_data"], PDO::PARAM_STR);
            $stmt->bindParam(":residency_street", self::$residency["street"], PDO::PARAM_STR);
            $stmt->bindParam(":residency_street_no", self::$residency["street_no"], PDO::PARAM_STR);
            $stmt->bindParam(":residency_city", self::$residency["city"], PDO::PARAM_STR);
            $stmt->bindParam(":residency_postal_code", self::$residency["postal_code"], PDO::PARAM_STR);
            $stmt->bindParam(":residency_province", self::$residency["province"], PDO::PARAM_STR);
            $stmt->bindParam(":residency_region", self::$residency["region"], PDO::PARAM_STR);
            $stmt->bindParam(":residency_city", self::$residency["city"], PDO::PARAM_STR);
            // Documents
            $stmt->bindParam(":documents_fiscal_code", self::$documents["fiscal_code"], PDO::PARAM_STR);
            $stmt->bindParam(":documents_identity_document", self::$documents["identity_document"], PDO::PARAM_STR);
            $stmt->bindParam(":documents_released_by", self::$documents["released_by"], PDO::PARAM_STR);
            $stmt->bindParam(":documents_released_date", $documents_released_date, PDO::PARAM_STR);
            // Contacts
            $stmt->bindParam(":contacts_telephone_number", self::$contacts["telephone_number"], PDO::PARAM_STR);
            $stmt->bindParam(":contacts_cellular_number", self::$contacts["cellular_number"], PDO::PARAM_STR);
            $stmt->bindParam(":contacts_email_address", self::$contacts["email_address"], PDO::PARAM_STR);
            // Survey ID
            $stmt->bindParam(":survey", $survey_id, PDO::PARAM_STR);
            // The user wants to donate
            $stmt->bindParam(":declared_donation", self::$extra["declared_donation"], PDO::PARAM_STR);
            // The user wants to be part of the Net
            $stmt->bindParam(":requires_to_be_part_of_the_net", $membership_requested, PDO::PARAM_STR);
            // Privacy
            $stmt->bindParam(":privacy_agree", $privacy_agree, PDO::PARAM_STR);
            $stmt->bindParam(":privacy_allow", $privacy_allow, PDO::PARAM_STR);
            // User data
            $stmt->bindParam(":user_ip", $user_ip_address, PDO::PARAM_STR);
            $stmt->bindParam(":user_agent", $user_agent, PDO::PARAM_STR);

            $stmt->execute();
        } catch(PDOException $e) {
            // print $e->getMessage();

            // There was an error
            // redirect the user to the error page
            wp_redirect( get_site_url() . "/errore");
        }
        // Send the email
        self::send_mail_to_user();
        self::send_mail_to_admin();
        wp_redirect(get_site_url() . "/associazione/moduli/modulo-di-registrazione-soci-sostenitori/registrazione-avvenuta-con-successo");
    }

    // Send the email to the user
    private static function send_mail_to_user() {
        self::$mail->addAddress(self::$contacts["email_address"], self::$personal_data["name"] . " " . self::$personal_data["last_name"]);
        self::$mail->addReplyTo("info@retisenzafrontiere.org", "Reti Senza Frontiere");
        self::$mail->isHTML(false);

        self::$mail->Subject = "Registrazione a Reti Senza Frontiere";
        // Extract body text
        $content = file_get_contents("wp-content/themes/RetiSenzaFrontiere/templates/email/reg_user_text.txt");
        $user_mail_text = utf8_decode(file_get_contents("wp-content/themes/RetiSenzaFrontiere/templates/email/reg_user_text.txt"));
        $user_mail_text = str_replace(array("{name}", "{year}"), array(self::$personal_data["name"], date("Y") . "-" . (date("Y") + 1)), $user_mail_text);
        // Append signature
        $user_mail_text .= "\n--=\n\nLo staff di Reti Senza Frontiere";
        self::$mail->Body = $user_mail_text;

        if(!self::$mail->send()) {
            print "Message could not be sent.";
            echo 'Mailer Error: ' . self::$mail->ErrorInfo;
        } else {
            echo 'Message has been sent';
        }
    }

    private static function send_mail_to_admin() {
        self::$mail->ClearAddresses();
        self::$mail->addAddress("registrazioni@retisenzafrontiere.org", "Reti Senza Frontiere");

        self::$mail->Subject = "Registrazione dal sito";
        // Body text
        $content = "Ciao,\n" . self::$personal_data["name"] . " " . self::$personal_data["last_name"] . " ha appena fatto una registrazione dal sito.\n";
        if(self::$extra["net_membership_requested"] == "on") {
            $content .= "L'utente ha richiesto inoltre di entrare a far parte della Rete dell'Associazione.\n";
        }
        $content .= "Controllate che il bonifico venga effettuato...\n\n";
        $content .= "\n--=\n\nIl sito di Reti Senza Frontiere";

        self::$mail->Body = $content;
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
        $is_male = self::is_male(self::$personal_data["name"]);
        $has_donation = ((self::$extra["declared_donation"] > 0) ? true : false);

        $filename = "documents/ricevuta_registrazione_" . self::receipt_id() . "-" . date("Y-m-d") . ".pdf";
        $fpdf = new FPDF();
        $fpdf->AddFont("Ubuntu", "", "Ubuntu-R.php");
        $fpdf->AddFont("Ubuntu", "B", "Ubuntu-B.php");
        $fpdf->AddFont("Ubuntu", "I", "Ubuntu-RI.php");
        $fpdf->AddFont("Ubuntu", "BI", "Ubuntu-BI.php");
        $fpdf->AddFont("UbuntuMono", "", "UbuntuMono-R.php");
        $fpdf->AddFont("UbuntuLight", "", "Ubuntu-L.php");
        $fpdf->AddFont("Libertine", "", "LinLibertine_R.php");
        $fpdf->AddFont("Libertine", "B", "LinLibertine_RB.php");

        $fpdf->AddPage();
        $fpdf->Image(get_template_directory_uri_images() . "/bg_carta_intestata.png", 0, 0, 210, 297);
        $fpdf->Image(get_template_directory_uri_images() . "/claim_500.png", 25, 10, 12, 12);

        /**
         * Header
         */
        $fpdf->SetX(150);
        $fpdf->SetFont("Libertine", "B", 7);
        $fpdf->Cell(40, 2.5, "Reti Senza Frontiere", 0, 1, "R");
        $fpdf->SetXY(150, 12.5);
        $fpdf->SetFont("Libertine", "", 7);
        $fpdf->Cell(40, 2.5, "Associazione senza scopo di lucro", 0, 1, "R");
        $fpdf->SetXY(156, 16);
        $fpdf->Cell(34, 2.5, "T: 06 21127155", 0, 1, "R");
        $fpdf->SetXY(156, 18.5);
        $fpdf->Cell(4, 2.5, "E:", 0, 1);
        $fpdf->SetXY(160, 18.5);
        $fpdf->SetTextColor(8, 110, 180);
        $fpdf->Cell(30, 2.5, "info@retisenzafrontiere.org", 0, 1, "R", false, "mailto:info@retisenzafrontiere.org");
        $fpdf->SetXY(156, 21);
        $fpdf->SetTextColor(0, 0, 0);
        $fpdf->Cell(34, 2.5, "CF: 93024780582", 0, 1, "R");
        $fpdf->SetXY(156, 23.5);
        $fpdf->Cell(34, 2.5, "PI: 13811511008", 0, 1, "R");
        $fpdf->SetXY(156, 30);
        $fpdf->SetTextColor(8, 110, 180);
        $fpdf->Cell(34, 2.5, "http://retisenzafrontiere.org", 0, 1, "R", false, "http://retisenzafrontiere.org");

        /**
         * Body
         */
        // Title
        $fpdf->SetFont("Ubuntu", "", 18);
        $fpdf->SetXY(36, 45);
        $fpdf->SetTextColor(0, 0, 0);
        $fpdf->Cell(36, 10, "Modulo d'iscrizione", 0, 1);
        $fpdf->SetFont("Ubuntu", "", 14);
        $fpdf->SetTextColor(150, 150, 150);
        $fpdf->SetX(36);
        $fpdf->Cell(36, 10, "Ricevuta", 0, 1);
        $fpdf->SetTextColor(0, 0, 0);
        $fpdf->SetFont("Ubuntu", "", 11);
        $fpdf->SetXY(36, 80);
        $content = file_get_contents("wp-content/themes/RetiSenzaFrontiere/templates/pdf/receipt_text.txt");
        $content = str_replace(
            array(
                "{il_la}",
                "{sig_ra}",
                "{name}",
                "{last_name}",
                "{date}",
                "{wtbpn}",
                "{o_a}"
            ),
            array (
                (($is_male) ? "il" : "la"),
                (($is_male) ? "sign." : "sig.ra"),
                self::$personal_data["name"],
                self::$personal_data["last_name"],
                date("d/m/Y"),
                ((self::$extra["net_membership_requested"] == "on") ? "Il richiedente ha richiesto di entrare a far parte della Rete dell'Associazione e ha fornito i dati per poterne valutare la fattibilità tecnica.\n\n" : ""),
                (($is_male) ? "o" : "a")
            ),
            $content
        );
        $fpdf->MultiCell(155, 5, utf8_decode($content), 0, "L");

        // Bank data
        $fpdf->Rect(36, 165, 100, 45);
        $fpdf->SetFont("Ubuntu", "", 14);
        $fpdf->SetTextColor(150, 150, 150);
        $fpdf->SetXY(36, 155);
        $fpdf->Cell(100, 5, "Dati Bancari", 0, 1, "L");
        $fpdf->SetFont("Ubuntu", "B", 10);
        $fpdf->SetTextColor(0, 0, 0);
        $fpdf->SetXY(38, 167);
        $fpdf->Cell(96, 5, "Banca Popolare Etica", 0, 1, "L");
        $fpdf->SetFont("Ubuntu", "", 10);
        $fpdf->SetXY(38, 172);
        $fpdf->MultiCell(96, 5, "Via Parigi, 17\n00185 Roma", 0, "L");
        $fpdf->SetFont("Ubuntu", "", 10);
        $fpdf->SetTextColor(150, 150, 150);
        $fpdf->SetXY(38, 185);
        $fpdf->Cell(25, 5, "Codice IBAN:", 0, 0, "R");
        $fpdf->SetFont("UbuntuMono", "", 10);
        $fpdf->SetTextColor(0, 0, 0);
        $fpdf->Cell(71, 5, "IT 08 X 03599 01899 050188529945", 0, 1, "L");
        $fpdf->SetFont("Ubuntu", "", 10);
        $fpdf->SetTextColor(150, 150, 150);
        $fpdf->SetXY(38, 190);
        $fpdf->Cell(25, 5, "Intestazione:", 0, 0, "R");
        $fpdf->SetFont("Ubuntu", "", 10);
        $fpdf->SetTextColor(0, 0, 0);
        $fpdf->Cell(71, 5, "Associazione Reti Senza Frontiere", 0, 1, "L");
        $description = "Iscrizione Associazione Reti Senza Frontiere anno " . date("Y") . "/" . (date("Y") + 1) . (($has_donation) ? " con donazione" : "");
        $fpdf->SetFont("Ubuntu", "", 10);
        $fpdf->SetTextColor(150, 150, 150);
        $fpdf->SetXY(38, 195);
        $fpdf->Cell(25, 5, "Causale:", 0, 0, "R");
        $fpdf->SetFont("Ubuntu", "I", 10);
        $fpdf->SetTextColor(0, 0, 0);
        $fpdf->MultiCell(71, 5, $description, 0, "L");

        // Declared donation
        if($has_donation) {
            $fpdf->SetFont("Ubuntu", "", 10);
            $fpdf->SetTextColor(0, 0, 0);
            $fpdf->SetXY(36, 230);
            $fpdf->Cell(135, 5, "Decidendo inoltre di versare una donazione di sostegno di " . EURO, 0, 0, "R");
            $fpdf->Cell(20, 5, self::$extra["declared_donation"], 1, 1, "R");
        }
        // Total
        $fpdf->SetFont("Ubuntu", "B", 10);
        $fpdf->SetXY(36, 238);
        $fpdf->Cell(135, 5, "Per un totale di " . EURO, 0, 0, "R");
        $fpdf->Cell(20, 5, (30 + self::$extra["declared_donation"]), 1, 1, "R");

        /* ------------------------------------------------------------------ */

        $fpdf->AddPage();
        $fpdf->Image(get_template_directory_uri_images() . "/bg_carta_intestata.png", 0, 0, 210, 297);
        $fpdf->Image(get_template_directory_uri_images() . "/claim_500.png", 25, 10, 12, 12);

        /**
         * Header
         */
        $fpdf->SetX(150);
        $fpdf->SetFont("Libertine", "B", 7);
        $fpdf->Cell(40, 2.5, "Reti Senza Frontiere", 0, 1, "R");
        $fpdf->SetXY(150, 12.5);
        $fpdf->SetFont("Libertine", "", 7);
        $fpdf->Cell(40, 2.5, "Associazione senza scopo di lucro", 0, 1, "R");
        $fpdf->SetXY(156, 16);
        $fpdf->Cell(34, 2.5, "T: 06 21127155", 0, 1, "R");
        $fpdf->SetXY(156, 18.5);
        $fpdf->Cell(4, 2.5, "E:", 0, 1);
        $fpdf->SetXY(160, 18.5);
        $fpdf->SetTextColor(8, 110, 180);
        $fpdf->Cell(30, 2.5, "info@retisenzafrontiere.org", 0, 1, "R", false, "mailto:info@retisenzafrontiere.org");
        $fpdf->SetXY(156, 21);
        $fpdf->SetTextColor(0, 0, 0);
        $fpdf->Cell(34, 2.5, "CF: 93024780582", 0, 1, "R");
        $fpdf->SetXY(156, 23.5);
        $fpdf->Cell(34, 2.5, "PI: 13811511008", 0, 1, "R");
        $fpdf->SetXY(156, 30);
        $fpdf->SetTextColor(8, 110, 180);
        $fpdf->Cell(34, 2.5, "http://retisenzafrontiere.org", 0, 1, "R", false, "http://retisenzafrontiere.org");

        /**
         * Body
         */
        // Title
        $fpdf->SetFont("UbuntuLight", "", 16);
        $fpdf->SetXY(36, 45);
        $fpdf->SetTextColor(0, 0, 0);
        $fpdf->Cell(36, 10, "Informazioni riguardo le donazioni", 0, 1);
        $fpdf->SetFont("Ubuntu", "", 9);
        $fpdf->SetXY(36, 55);
        $donation_info = file_get_contents("wp-content/themes/RetiSenzaFrontiere/templates/pdf/donation_info.txt");
        $fpdf->MultiCell(155, 5, utf8_decode($donation_info), 0, "L");
        //
        $fpdf->SetFont("UbuntuLight", "", 16);
        $fpdf->SetXY(36, 95);
        $fpdf->SetTextColor(0, 0, 0);
        $fpdf->Cell(36, 10, "Informazioni riguardo al Regolamento di Servizio", 0, 1);
        $fpdf->SetFont("Ubuntu", "", 9);
        $fpdf->SetXY(36, 105);
        $regulation_info = file_get_contents("wp-content/themes/RetiSenzaFrontiere/templates/pdf/regulation_info.txt");
        $fpdf->MultiCell(155, 5, utf8_decode($regulation_info), 0, "L");
        $fpdf->SetX(36);
        $fpdf->Cell(155, 5, get_site_url() . "/associazione/regolamento", 0, 1, "L", false, get_site_url() . "/associazione/regolamento");
        //
        $fpdf->SetFont("UbuntuLight", "", 16);
        $fpdf->SetXY(36, 140);
        $fpdf->SetTextColor(0, 0, 0);
        $fpdf->Cell(36, 10, "Informativa ai sensi dell'Art. 13 del D.Lgs. 196/2003", 0, 1);
        $fpdf->SetFont("Ubuntu", "", 9);
        $fpdf->SetXY(36, 150);
        $privacy_info = file_get_contents("wp-content/themes/RetiSenzaFrontiere/templates/pdf/privacy_info.txt");
        $fpdf->MultiCell(155, 5, utf8_decode($privacy_info), 0, "L");
        $fpdf->SetX(36);
        $fpdf->Cell(155, 5, get_site_url() . "/informativa-sulla-privacy", 0, 1, "L", false, get_site_url() . "/informativa-sulla-privacy");

        // $pdf->Output("D");
        $fpdf->Output("F", $filename);
        return $filename;
    }
}

?>
