<?php
/*
Template Name: Graduatorie
*/

$db_config = parse_ini_file(ABSPATH . "wp-content/themes/RetiSenzaFrontiere/configs/database.ini");
$pdo = new PDO("mysql:host=" . $db_config["host"] . ";dbname=rsf_data", $db_config["user"], $db_config["pass"]);
$sql = <<<SQL
    SELECT
    rsf_classifications.id,
    rsf_classifications.member_id,
    rsf_classifications.digital_divide_score,
    rsf_classifications.technical_score,
    rsf_classifications.total_score,
    rsf_classifications.date,
    rsf_members.name,
    rsf_members.last_name
    FROM `rsf_classifications`
    JOIN `rsf_members` on `member_id` = rsf_members.id
    WHERE rsf_members.requires_to_be_part_of_the_net = '1' AND rsf_members.evaluated = '1'
SQL;
$query = $pdo->query($sql);
$requests = $query->fetchAll(PDO::FETCH_ASSOC);
$has_requests = (count($requests) > 0) ? true : false;

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
                            ?>
                            <h2>Richieste di adesione alla Rete</h2>
                            <?php breadcrumb(); ?>
                            <p>A seguire l'elenco delle graduatorie per i Soci che hanno fatto richiesta di adesione alla Rete dell'Associazione.</p>
                            <p>
                                I criteri di valutazione sono lo <u>svantaggio geografico</u> e la <u>fattibilità tecnica</u>.<br />
                                Il punteggio relativo allo svantaggio geografico viene assegnato dal Consiglio Direttivo, che è l'organo amministrativo dell'Associazione;<br />
                                Il punteggio relativo alla fattibilità tecnica viene assegnato dal Consiglio Tecnico.<br />
                                Ciascuna valutazione assegna un punteggio da 0 a 10, per un totale massimo di 20 punti.<br />
                                Il punteggio totale stabilirà la priorità <i>indicativa</i> di creazione del nodo di collegamento alla Rete.
                            </p>
                            <p>I Consigli potranno comunque stabilire per ragioni di altra natura (strategia di espansione, densità di copertura, ecc...) di dare priorità differenti rispetto a tale punteggio.</p>
                            <divc class="spacer-50"></div>
                            <?php
                            if($has_requests) {
                                ?>
                                <table class="bordered highlight responsive-table">
                                    <thead>
                                        <tr>
                                            <th data-field="name"><?php print __("Nome", "rsf"); ?></th>
                                            <th data-field="digital_divide_score"><?php print __("Svantaggio geografico", "rsf"); ?></th>
                                            <th data-field="technical_score"><?php print __("Fattibilità tecnica", "rsf"); ?></th>
                                            <th data-field="technical_score"><?php print __("Punteggio totale", "rsf"); ?></th>
                                            <th data-field="date"><?php print __("Data valutazione", "rsf"); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach($requests as $k => $v) {
                                            $total = $v["total_score"];
                                            if($total >= 10 && $total < 15) {
                                                $colourize = "orange lighten-5";
                                            } else if($total >= 15) {
                                                $colourize = "green lighten-5";
                                            } else {
                                                $colourize = "";
                                            }
                                            ?>
                                            <tr class="<?php print $colourize; ?>">
                                                <td><?php print ucwords($v["name"] . " " . substr($v["last_name"], 0, 1) . "."); ?></td>
                                                <td><?php print $v["digital_divide_score"]; ?></td>
                                                <td><?php print $v["technical_score"]; ?></td>
                                                <td><b><?php print $total; ?></b></td>
                                                <td><?php print date("d/m/Y", strtotime($v["date"])); ?></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <divc class="spacer-100"></div>
                                <?php
                            } else {
                                ?>
                                <p class="flow-text valign-wrapper">
                                    <span class="fa fa-fw fa-2x fa-check green-text"></span>&nbsp;&nbsp;<?php print __("Attualmente non ci sono valutazioni o le valutazioni sono state tutte evase"); ?>
                                </p>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
<?php else: ?>
<?php endif; ?>

<?php get_footer(); ?>
