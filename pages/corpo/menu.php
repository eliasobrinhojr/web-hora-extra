<div class="menu">
    <ul>					
        <li><a href="../../view/index.php"><i class="fa fa-home" aria-hidden="true"></i>Home</a></li>
        <li><a href="../manter/relatorio.php"><i class="fa fa-clipboard" aria-hidden="true"></i>Relatórios</a></li>

        <div class="accordion">
            <section class="accordion-item">
                <li><i class="fa fa-list-alt" aria-hidden="true"></i>Cadastros</li>
                <div class="accordion-item-content">
                    <li style="padding-left:10px;"><a href="../manter/hora_extra.php?acao=cadastrar"><i class="fa fa-money" aria-hidden="true"></i>Hora Extra</a></li>


                    <?php
                    if ($_SESSION['usuarioId'] == 1) {
                        ?>

                        <li style="padding-left:10px;"><a href="../manter/setores.php"><i class="fa fa-sitemap" aria-hidden="true"></i>Setores</a></li>
                        <li style="padding-left:10px;"><a href="../manter/aprovadores.php"><i class="fa fa-thumbs-up" aria-hidden="true"></i>Aprovadores</a></li>
                        <li style="padding-left:10px;"><a href="../manter/usuarios.php"><i class="fa fa-user" aria-hidden="true"></i>Usuarios</a></li>
                        <li style="padding-left:10px;"><a href="../manter/dias_uteis.php"><i class="fa fa-calendar" aria-hidden="true"></i>Dias Úteis</a></li>
                        <li style="padding-left:10px;"><a href="../manter/descricao_dias.php"><i class="fa fa-fire" aria-hidden="true"></i>Descrição de Dias</a></li>
                    <?php } else if ($_SESSION['acessos']['acs_IdTipoDeAcesso'] == 2) { ?>
                        <li style="padding-left:10px;"><a href="../manter/setores.php"><i class="fa fa-sitemap" aria-hidden="true"></i>Setores</a></li>
                        <li style="padding-left:10px;"><a href="../manter/dias_uteis.php"><i class="fa fa-calendar" aria-hidden="true"></i>Dias Úteis</a></li>
                        <?php } ?>
                </div>
            </section>
        </div>

<!--<li><a href="../../utils/sair.php"><i class="fa fa-power-off" aria-hidden="true"></i>Sair</a></li>-->

    </ul>
</div>