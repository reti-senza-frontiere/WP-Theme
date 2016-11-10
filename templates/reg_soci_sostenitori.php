<?php
/*
Template Name: Registrazione Soci Sostenitori
*/

get_header();

if(isset($_POST) && count($_POST) > 0) {
    print_r($_POST);
}
?>

<?php if(have_posts()) : ?>
    <?php while(have_posts()) : the_post(); ?>
        <div id="container-main" class="container-fluid">
            <div class="row">
                <div class="container">
                    <div class="row">
                        <div class="col l12 m12 s12">
                            <form method="post" action="" id="registration_form" style="display: none;">
                                <?php
                                if(!is_front_page()) {
                                    the_title("<h1>", "</h1>");
                                }
                                breadcrumb();
                                ?>
                                <div class="row">
                                    <div class="col s12">
                                        <ul class="tabs">
                                            <li class="tab" id="tab_personal_data"><a class="active" href="#personal_data">Informazioni personali</a></li>
                                            <li class="tab disabled" id="tab_residency"><a href="#residency">Residenza</a></li>
                                            <li class="tab disabled" id="tab_documents"><a href="#documents">Documenti di riconosimento</a></li>
                                            <li class="tab disabled" id="tab_contacts"><a href="#contacts">Contatti</a></li>
                                            <li class="tab disabled" id="tab_payment"><a href="#payment">Versamento</a></li>
                                      </ul>
                                    </div>
                                    <div class="spacer-100"></div>
                                    <form method="post" action="">
                                        <div id="personal_data" class="col s12 tab-content">
                                            <h4>Tipo di persona</h4>
                                            <div class="switch">
                                                <label>
                                                    Persona fisica
                                                    <input id="reg_person_type" type="checkbox">
                                                    <span class="lever"></span>
                                                    Persona giuridica
                                                </label>
                                            </div>
                                            <div class="spacer-40"></div>
                                            <div id="company_data" class="row hide">
                                                <div class="col l6 m6 s10">
                                                    <div class="row">
                                                        <div class="input-field col l8 m9 s10">
                                                            <input id="reg_company" name="reg_company" type="text" data-error />
                                                            <label for="reg_company" class="required">Ragione sociale <span>*</span></label>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="input-field col l4 m5 s6">
                                                            <input id="reg_vat_number" name="reg_vat_number" type="text" data-error />
                                                            <label for="reg_vat_number" class="required">Partita IVA <span>*</span></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="spacer-30"></div>

                                            <div class="row">
                                                <div class="col l7 m8 s12">
                                                    <div class="row">
                                                        <div class="input-field col l6 m6 s12">
                                                            <input id="reg_name" name="reg_name" type="text" data-error />
                                                            <label for="reg_name" class="required">Nome <span>*</span></label>
                                                        </div>
                                                        <div class="input-field col l6 m6 s12">
                                                            <input id="reg_last_name" name="reg_last_name" type="text" data-error />
                                                            <label for="reg_last_name" class="required">Cognome <span>*</span></label>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col l3 m4 s6">
                                                            <label for="reg_birth_date" class="required">Data di nascita <span>*</span></label>
                                                            <input id="reg_birth_date" name="reg_birth_date" type="text" class="datepicker" />
                                                        </div>
                                                        <div class="input-field col offset-l3 offset-m2 l6 m6 s11">
                                                            <input id="reg_birth_place" name="reg_birth_place" type="text" data-error />
                                                            <label for="reg_birth_place" class="required">Luogo di nascita <span>*</span></label>
                                                        </div>
                                                    </div>
                                                    <button class="waves-effect waves-light btn deep-orange right" data-activate="residency">
                                                        <i class="material-icons right">keyboard_arrow_right</i> Avanti
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="residency" class="col s12 tab-content">
                                            <div class="row">
                                                <div class="col l7 m8 s12">
                                                    <h4>Residenza</h4>

                                                    <div class="row">
                                                        <div class="input-field col l12 m12 s12">
                                                            <input id="reg_search_map" name="reg_search_map" type="text" data-error />
                                                            <label for="reg_search_map" class="required">Cerca...</label>
                                                        </div>
                                                    </div>
                                                    <input id="reg_map_data" name="reg_map_data" type="hidden" />
                                                    <div id="map"></div>
                                                    <div class="row">
                                                        <div class="input-field col l7 m7 s7">
                                                            <input placeholder="Via" id="reg_street" name="reg_street" type="text" data-error />
                                                        </div>
                                                        <div class="input-field col l2 m2 s4">
                                                            <input placeholder="Numero civico" id="reg_street_no" name="reg_street_no" type="text" data-error />
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="input-field col l6 m6 s6">
                                                            <input placeholder="Città" id="reg_city" name="reg_city" type="text" data-error />
                                                        </div>
                                                        <div class="input-field col offset-l1 offset-m1 l3 m4 s5">
                                                            <input placeholder="CAP" id="reg_postal_code" name="reg_postal_code" type="text" maxlength="5" data-error />
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="input-field col l6 m6 s6">
                                                            <input placeholder="Provincia" id="reg_province" name="reg_province" type="text" data-error />
                                                        </div>
                                                        <div class="input-field col offset-l1 offset-m1 l5 m5 s6">
                                                            <input placeholder="Regione" id="reg_region" name="reg_region" type="text" data-error />
                                                        </div>
                                                    </div>
                                                    <button class="waves-effect waves-light btn deep-orange right" data-activate="documents">
                                                        <i class="material-icons right">keyboard_arrow_right</i> Avanti
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="documents" class="col s12 tab-content">
                                            <div class="row">
                                                <div class="col l7 m8 s12">
                                                    <h4>Documenti di riconoscimento</h4>

                                                    <div class="row">
                                                        <div class="input-field col l6 m6 s10">
                                                            <input id="reg_fiscal_code" name="reg_fiscal_code" type="text" data-error />
                                                            <label for="reg_name" class="required">Codice fiscale <span>*</span></label>
                                                        </div>
                                                        <div class="input-field col l6 m6 s10">
                                                            <input id="reg_identity_document" name="reg_identity_document" type="text" data-error />
                                                            <label for="reg_identity_document" class="required">Documento d'identità <span>*</span></label>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="input-field col offset-l6 offset-m6 l6 m6 s12">
                                                            <input id="reg_released_by" name="reg_released_by" type="text" data-error />
                                                            <label for="reg_released_by" class="required">Rilasciato da <span>*</span></label>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="input-field col offset-l6 offset-m6 l4 m5 s6">
                                                            <label for="reg_released_date" class="required">In data <span>*</span></label>
                                                            <input id="reg_released_date" name="reg_released_date" type="text" class="datepicker" />
                                                        </div>
                                                    </div>
                                                    <button class="waves-effect waves-light btn deep-orange right" data-activate="contacts">
                                                        <i class="material-icons right">keyboard_arrow_right</i> Avanti
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="contacts" class="col s12 tab-content">
                                            <div class="row">
                                                <div class="col l7 m8 s12">
                                                    <h4>Contatti</h4>

                                                    <div class="row">
                                                        <div class="input-field col l5 m5 s10">
                                                            <input id="reg_telephone_number" name="reg_telephone_number" type="text" />
                                                            <label for="reg_telephone_number">Numero di telefono</label>
                                                        </div>
                                                        <div class="input-field col offset-l1 offset-m1 l5 m5 s10">
                                                            <input id="reg_cellular_number" name="reg_cellular_number" type="text" data-error />
                                                            <label for="reg_cellular_number" class="required">Numero di cellulare <span>*</span></label>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="input-field col l10 m10 s12">
                                                            <input id="reg_email_address" name="reg_email_address" type="email" data-error />
                                                            <label for="reg_email_address" class="required">Indirizzo e-mail <span>*</span></label>
                                                        </div>
                                                    </div>
                                                    <button class="waves-effect waves-light btn deep-orange right" data-activate="payment">
                                                        <i class="material-icons right">keyboard_arrow_right</i> Avanti
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="payment" class="col s12 tab-content">
                                            <div class="row">
                                                <div class="col l7 m8 s12">
                                                    <h4>Versamento quota e richiesta di adesione</h4>

                                                    <p>
                                                        <input type="checkbox" id="reg_net_member" name="reg_net_member" class="filled-in" />
                                                        <label for="reg_net_member">Ho problemi ad avere Internet e chiedo di far parte della Rete dell'Associazione</label>
                                                    </p>
                                                    <div id="reg_net_member_why" class="indent-30" style="display: none;">
                                                        <div class="spacer-20"></div>
                                                        <h6><span class="fa fa-fw fa-info-circle cyan-text"></span> Che tipo di problema hai?</h6>
                                                        <p>Queste informazioni ci sono utili per capire lo stato della connettività nella tua zona</p>
                                                        <p>
                                                            <input type="checkbox" id="reg_net_member_no_connectivity" name="reg_net_member_why[no_connectivity]" class="filled-in" />
                                                            <label for="reg_net_member_no_connectivity">Non sono raggiunto da connettività</label>
                                                        </p>
                                                        <p>
                                                            <input type="checkbox" id="reg_net_member_only_tethering" name="reg_net_member_why[only_tethering]" class="filled-in" />
                                                            <label for="reg_net_member_only_tethering">È possibile navigare ma solo via GSM/UMTS (Telefono)</label>
                                                        </p>
                                                        <p>
                                                            <input type="checkbox" id="reg_net_member_low_connectivity" name="reg_net_member_why[low_connectivity]" class="filled-in" />
                                                            <label for="reg_net_member_low_connectivity">Sono raggiunto dagli operatori ma il servizio è scarso e/o inefficiente</label>
                                                        </p>
                                                        <p>
                                                            <input type="checkbox" id="reg_net_member_too_expensive" name="reg_net_member_why[too_expensive]" class="filled-in" />
                                                            <label for="reg_net_member_too_expensive">Sono raggiunto dagli operatori ma a costi troppo eccessivi per me</label>
                                                        </p>
                                                        <p>
                                                            <input type="checkbox" id="reg_net_member_no_satisfied" name="reg_net_member_why[no_satisfied]" class="filled-in" />
                                                            <label for="reg_net_member_no_satisfied">Gli operatori di zona non sanno/riescono a soddisfare le mie esigenze</label>
                                                        </p>
                                                        <div class="spacer-10"></div>
                                                        <div class="row">
                                                            <div class="col l2 m2 s3">
                                                                <p>
                                                                    <input type="checkbox" id="reg_net_member_other" name="reg_net_member_why[other]" class="filled-in" />
                                                                    <label for="reg_net_member_other">Altro:</label>
                                                                </p>
                                                            </div>
                                                            <div class="col l10 m10 s9">
                                                                <input id="reg_net_member_other_reason" name="reg_net_member_why[other][reason]" type="text" placeholder="Motivo" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="spacer-50"></div>
                                                    <h5>Informazioni sul bonifico</h5>
                                                    <p>Per procedere con l'iscrizione è necessario versare l'importo della prima quota di iscrizione (€30).</p>
                                                    <p>
                                                        Nella causale è necessario indicare:<br />
                                                        <tt>Quota iscrizione Associazione Reti Senza Frontiere anno <?php print date("Y") . "-" . (date("Y") + 1); ?></tt><br />
                                                        - oppure -<br />
                                                        <tt>Quota iscrizione Associazione Reti Senza Frontiere anno <?php print date("Y") . "-" . (date("Y") + 1); ?> con donazione</tt><br />
                                                    </p>
                                                    <!-- <p>
                                                        <input class="with-gap" name="reg_payment_type" type="radio" id="reg_payment_sepa" checked="checked" />
                                                        <label for="reg_payment_sepa">Bonifico bancario</label>
                                                    </p>
                                                    <p>
                                                        <input class="with-gap" name="reg_payment_type" type="radio" id="reg_payment_paypal"  />
                                                        <label for="reg_payment_paypal">Paypal</label>
                                                    </p> -->
                                                    <div class="spacer-10"></div>
                                                    <div class="row">
                                                        <div class="input-field col offset-l3 offset-m3 l7 m7 s10">
                                                            <p class="right-align">Decido inoltre di effettuare una donazione di €</p>
                                                        </div>
                                                        <div class="col l2 m2 s2">
                                                            <input id="reg_donation" name="reg_donation" type="number" min="0" value="0" />
                                                        </div>
                                                    </div>

                                                    <div class="spacer-20"></div>
                                                    <b>Informazioni riguardo le donazioni</b>
                                                    <p>L'aggiunta del termine "donazione" nella causale del bonifico è importante sia per la tracciabilità che per la deducibilità dell'importo versato, inoltre ci aiuta per la gestione contabile dello stesso.</p>
                                                    <p>
                                                        Le donazioni a Reti Senza Frontiere sono deducibili dal reddito complessivo del soggetto erogatore nel limite del dieci per cento (10%) dello stesso, e comunque con un massimo di 70.000 euro annui (art. 14 comma 1 del Decreto Legge 35/05 convertito in legge n° 80 del 14/05/2005).<br />
                                                        In alternativa, le donazioni possono essere detratte dall'imposta lorda per un valore del 26% a partire dal 2014, fino ad un massimo di 2.065,83 euro (art. 15, comma 1.1 d.P.R. 917/86).
                                                    </p>
                                                    <div class="spacer-20"></div>
                                                    <hr />
                                                    <div class="spacer-20"></div>
                                                    <!-- Privacy -->
                                                    <?php require_once("resources/_informativa_privacy.tpl"); ?>
                                                    <div class="spacer-20"></div>
                                                    <p>
                                                        <input type="checkbox" id="reg_privacy_agree" name="reg_privacy_agree" class="filled-in" data-error />
                                                        <label class="required" for="reg_privacy_agree">Dichiaro di aver letto e di accettare l'<a target="_blank" href="<?php print get_site_url(); ?>/informativa-sulla-privacy/">informativa sul trattamento dei dati personali</a> <span>*</span></label>
                                                    </p>
                                                    <p>
                                                        <input type="checkbox" id="reg_privacy_allow" name="reg_privacy_allow" class="filled-in" data-error />
                                                        <label class="required" for="reg_privacy_allow">Acconsento al trattamento dei miei dati personali per le finalità previste nell'<a target="_blank" href="<?php print get_site_url(); ?>/informativa-sulla-privacy/">informativa sul trattamento dei dati personali</a> <span>*</span></label>
                                                    </p>
                                                    <div class="spacer-50"></div>

                                                    <!-- Button -->
                                                    <button class="waves-effect waves-light btn green right" data-activate="save">
                                                        <i class="material-icons right">done</i> Salva e inoltra
                                                    </button>
                                                </div>
                                                <div class="col offset-l1 offset-m1 l4 m3 s12">
                                                    <div id="bank_data">
                                                        <?php require_once("resources/_dati_bancari.tpl"); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
<?php else: ?>
<?php endif; ?>

<?php get_footer(); ?>
