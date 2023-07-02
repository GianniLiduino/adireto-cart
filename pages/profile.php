<?php
require __DIR__ . './Layouts/html-top.php';
require __DIR__ . './Components/Header.php';
?>

<section id="section-profile">

    <div class="container">
        <div class="d-flex align-items-start">
            <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <button class="nav-link rounded-0 active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Perfil</button>
            </div>
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab" tabindex="0">
                    <div class="row">
                        <div class="col-12">
                            <h3>Histórico de compra</h3>
                        </div>
                        <div class="col-12">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Subtotal</th>
                                        <th>Descontos</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($carts as $cart) { ?>
                                        <tr>
                                            <td><?php echo $cart['id'] ?></td>
                                            <td><?php echo number_format($cart['total'], 2, ',', '.') ?></td>
                                            <td><?php echo number_format($cart['total'] - $cart['total_payable'], 2, ',', '.') ?></td>
                                            <td><?php echo number_format($cart['total_payable'], 2, ',', '.') ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>



<?php
require __DIR__ . './Layouts/html-bottom.php';
