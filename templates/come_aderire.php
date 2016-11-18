<?php
/*
Template Name: Come aderire
*/

get_header();
?>

<?php if(have_posts()) : ?>
    <?php while(have_posts()) : the_post(); ?>
        <div id="container-main" class="container-fluid">
            <div class="row">
                <div class="container">
                    <div class="row">
                        <div class="col l12 m12 s12">
                            <?php
                            if(!is_front_page()) {
                                the_title("<h1>", "</h1>");
                            }
                            breadcrumb();
                            ?>
                            <div class="row">
                                <div class="col l7 m7 s12">
                                    <p>
                                        Per aderire è necessario essere maggiorenni e compilare il <a href="<?php print get_site_url(); ?>/associazione/moduli/modulo-di-registrazione-soci-sostenitori/">modulo di registrazione</a>.<br />
                                        Una volta registrati al portale e aver versato la quota di prima adesione si diverrà Soci Sostenitori, attraverso cui si potrà partecipare alle attività culturali dell'Associazione e usufruire dei servizi appositi nell'area riservata.; inoltre si potrà fare richiesta di adesione alla Rete dell'Associazione, in modo da poter indirizzare la creazione di nuovi nodi verso la propria abitazione, qualora non si venga già raggiunti.<br />
                                        Alla prossima riunione del Consiglio Direttivo, verranno valutate tutte le richieste e ad ognuna verrà assegnato un punteggio in base alla priorità di svantaggio geografico e alle fattibilità tecniche.<br />
                                    </p>
                                    <p>
                                        In caso positivo verrete contattati privatamente per un sopralluogo tecnico in sede, per fissare così un primo appuntamento al fine di valutare eventuali spese accessorie aggiuntive, che dovranno comunque essere sostenute dall'interessato.<br />
                                        Una volta effettuato il primo pagamento della quota di Socio Ordinario o Promotore, verrà concordato un secondo appuntamento per i lavori di creazione dell'infrastruttura che vi renderà parte della Rete.
                                    </p>
                                    <div class="space-30"></div>
                                    <h3>In breve</h3>
                                    <ol class="browser-default">
                                     	<li>Compila il <a href="<?php print get_site_url(); ?>/associazione/moduli/modulo-di-registrazione-soci-sostenitori/">modulo di registrazione</a> e versa la quota di Socio Sostenitore (30€)</li>
                                     	<li>Ti viene assegnato un punteggio in graduatoria e non appena possibile <strong>sarai contattato</strong> per fissare un appuntamento per un sopralluogo in sede</li>
                                     	<li>Versa la quota di Socio Ordinario o Promotore (150€ o più), verremo perciò a costruire l'infrastruttura per collegarti alla nostra Rete</li>
                                    </ol>
                                    <div class="space-30"></div>
                                    <h3>Costi</h3>
                                    <p>
                                        Ricordiamo che <a href="<?php print get_site_url(); ?>/associazione/statuto#Articolo_11_8211_Norme_Transitorie">in base all'Art.11 del nostro Statuto</a>, e su decisione del Consiglio Direttivo, tutti i radioamatori e gli sperimentatori di rete accertati, qualora questi decidano di utilizzare un proprio apparato wifi per accedere alla nostra Rete, <span style="text-decoration: underline;">è stato fissato uno sconto pari ad € 50 (cinquanta) per la prima quota di adesione a Socio Ordinario</span>.<br />
                                        L'offerta avrà la durata del primo esercizio, scadrà quindi il 31 dicembre 2016.
                                    </p>
                                    <p>
                                        Per poterne beneficiare è sufficiente indicare il proprio codice di radioamatore in fase di iscrizione.
                                    </p>
                                </div>
                                <div class="col l4 m4 s12 offset-l1 offset-m1">
                                    <?php require_once("resources/_dati_bancari.tpl"); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col l4 m4 s12">
                                    <div class="card">
                                        <div class="card-image">
                                            <img src="<?php print get_template_directory_uri_images() . "/tessera_socio_sostenitore-2016.png"; ?>">
                                            <!-- <span class="card-title">Card Title</span> -->
                                        </div>
                                        <div class="card-content">
                                            <p>
                                                Per far parte di Reti Senza Frontiere e partecipare a tutte le attività dell'Associazione
                                            </p>
                                        </div>
                                        <div class="card-action">
                                            <h1 class="center-align deep-orange-text">€30</h1>
                                            <h6 class="center-align blue-grey-text">l'anno</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l4 m4 s12">
                                    <div class="card">
                                        <div class="card-image">
                                            <img src="<?php print get_template_directory_uri_images() . "/tessera_socio_ordinario-2016.png"; ?>">
                                            <!-- <span class="card-title">Card Title</span> -->
                                        </div>
                                        <div class="card-content">
                                            <p>
                                                Per attivare un proprio nodo ed essere parte della nostra Rete
                                            </p>
                                        </div>
                                        <div class="card-action">
                                            <div class="row">
                                                <div class="col l6 m6 s6">
                                                    <h1 class="center-align deep-orange-text">€150</h1>
                                                    <h6 class="center-align blue-grey-text">il primo anno</h6>
                                                </div>
                                                <div class="col l6 m6 s6">
                                                    <h1 class="center-align deep-orange-text">€100</h1>
                                                    <h6 class="center-align blue-grey-text">rinnovi successivi</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l4 m4 s12">
                                    <div class="card">
                                        <div class="card-image">
                                            <img src="<?php print get_template_directory_uri_images() . "/tessera_socio_promotore-2016.png"; ?>">
                                            <!-- <span class="card-title">Card Title</span> -->
                                        </div>
                                        <div class="card-content">
                                            <p>
                                                Per attivare un proprio nodo ed essere parte della nostra Rete, apportando un contributo economico
                                            </p>
                                        </div>
                                        <div class="card-action">
                                            <div class="row">
                                                <div class="col l6 m6 s6">
                                                    <h1 class="center-align deep-orange-text">€195+</h1>
                                                    <h6 class="center-align blue-grey-text">il primo anno</h6>
                                                </div>
                                                <div class="col l6 m6 s6">
                                                    <h1 class="center-align deep-orange-text">€130+</h1>
                                                    <h6 class="center-align blue-grey-text">rinnovi successivi</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="spacer-50"></div>
                            <p class="center-align flow-text">
                                <i>Nota: è possibile effettuare una <a href="<?php print get_site_url(); ?>/associazione/sostienici/">donazione</a> in qualunque momento, e senza bisogno di registrazione</i>
                            </p>
                            <hr />
                            <div class="spacer-50"></div>
                            <h1 class="center-align">
                                <a class="blue-grey-text" href="<?php print get_site_url(); ?>/associazione/moduli/modulo-di-registrazione-soci-sostenitori/">Vai al modulo di registrazione &rsaquo;</a>
                            </h1>
                            <div class="spacer-50"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
<?php else: ?>
<?php endif; ?>

<?php get_footer(); ?>
