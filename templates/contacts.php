<?php
/*
Template Name: Contatti
*/

if(isset($_POST["contact_name"]) && isset($_POST["contact_last_name"]) && isset($_POST["contact_email"]) && isset($_POST["contact_subject"]) && isset($_POST["contact_message"]) && strlen($_POST["g-recaptcha-response"] > 0)) {
    // print_r($_POST);
    // sanitize form values
    $name       = sanitize_text_field($_POST["contact_name"]);
    $last_name  = sanitize_text_field($_POST["contact_last_name"]);
    $email      = sanitize_email($_POST["contact_email"]);
    $subject    = sanitize_text_field($_POST["contact_subject"]);
    $message    = esc_textarea($_POST["contact_message"]);

    // get the blog administrator's email address
    $to = "info@retisenzafrontiere.org";

    $headers = "From: " . $name . " <" . $email . ">" . "\r\n";

    // If email has been process for sending, display a success message
    $sent = wp_mail($to, $subject, $message, $headers);
    if($sent) {
        $result = '<div class="card-panel green white-text">';
        $result .= '<span class="fa fa-fw fa-2x fa-check left"></span>' . __("Il messaggio è stato inviato e verrà valutato al più presto", "rsf");
        $result .= '</div>';

        $_POST["contact_name"] = "";
        $_POST["contact_last_name"] = "";
        $_POST["contact_email"] = "";
        $_POST["contact_subject"] = "";
        $_POST["contact_message"] = "";
    } else {
        $result = '<div class="card-panel red white-text">';
        $result .= '<span class="fa fa-fw fa-2x fa-exclamation-circle left"></span>' . __("Si è verificato un errore.<br />Riprovare in un secondo momento");
        $result .= " (" . $GLOBALS['phpmailer']->ErrorInfo . ")";
        $result .= '</div>';
    }
}
get_header();
?>

<?php if(have_posts()) : ?>
    <?php while(have_posts()) : the_post(); ?>
        <div id="container-main" class="container-fluid">
            <div class="row">
                <div class="container">
                    <div class="row">
                        <div class="col l12 m12 s12">
                            <?php the_title('<h1>', '</h1>'); ?>
                            <div class="row">
                                <div class="col l7 m7 s12">
                                    <p><?php printf(__("Consiglio Direttivo (VoIP condiviso): <i class=\"fa fa-phone\"></i> %s</p>", "rsf"), "06 21127155"); ?>
                                    <p>
                                        Per questioni riguardanti la contabilità: <i class="fa fa-envelope-o"></i> <a class="mail" href="mailto:contabilita@retisenzafrontiere.org?subject=Richiesta%20informazioni"><img src="<?php print get_template_directory_uri_images(); ?>/text_email_contabilita.png" /></a><br />
                                        Per tutte le altre informazioni: <i class="fa fa-envelope-o"></i> <a class="mail" href="mailto:contatti@retisenzafrontiere.org?subject=Richiesta%20informazioni"><img src="<?php print get_template_directory_uri_images(); ?>/text_email_contatti.png" /></a>
                                    </p>
                                    <br />
                                    <hr />
                                    <h4>Oppure compila il modulo a seguire</h4>
                                    <br />
                                    <?php
                                    print (isset($result) ? $result : "");
                                    ?>
                                    <form method="post" action="<?php print esc_url($_SERVER["REQUEST_URI"]); ?>">
                                        <div class="row">
                                            <div class="input-field col l6 m6 s12">
                                                <input type="text" name="contact_name" id="name" pattern="[a-zA-Z0-9 ]+" value="<?php (isset($_POST["contact_name"]) ? esc_attr($_POST["contact_name"]) : ""); ?>" />
                                                <label for="name"><?php print __("Nome", "rsf"); ?></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col l6 m6 s12">
                                                <input type="text" name="contact_last_name" id="last_name" pattern="[a-zA-Z0-9 ]+" value="<?php (isset($_POST["contact_last_name"]) ? esc_attr($_POST["contact_last_name"]) : ""); ?>" />
                                                <label for="last_name"><?php print __("Cognome", "rsf"); ?></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col l6 m6 s12">
                                                <input type="email" name="contact_email" id="email" value="<?php (isset($_POST["contact_email"]) ? esc_attr($_POST["contact_email"]) : ""); ?>" />
                                                <label for="email"><?php print __("Indirizzo e-mail", "rsf"); ?></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col l12 m12 s12">
                                                <input type="text" name="contact_subject" id="subject" pattern="[a-zA-Z0-9 ]+" value="<?php (isset($_POST["contact_subject"]) ? esc_attr($_POST["contact_subject"]) : ""); ?>" />
                                                <label for="subject"><?php print __("Oggetto", "rsf"); ?></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col l12 m12 s12">
                                                <textarea type="text" name="contact_message" id="message" class="materialize-textarea"><?php (isset($_POST["contact_message"]) ? esc_attr($_POST["contact_message"]) : ""); ?></textarea>
                                                <label for="message"><?php print __("Messaggio", "rsf"); ?></label>
                                            </div>
                                        </div>
                                        <br />
                                        <?php require_once("resources/_g_recaptcha.tpl"); ?>
                                        <br />
                                        <button class="btn waves-effect waves-light deep-orange right" type="submit" name="action">
                                            <?php print __("Invia", "rsf"); ?>
                                        </button>
                                    </form>
                                </div>
                                <div class="col l4 m4 s12 offset-l1 offset-m1">
                                    <?php require_once("resources/_dati_bancari.tpl"); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
<?php else: ?>
<?php endif; ?>

<?php get_footer(); ?>
