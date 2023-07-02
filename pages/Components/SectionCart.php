<section id="sectionCart">
    <div class="container">
        <div class="row">
            <div class="col-12 mb-3">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th class="col-md-3">#</th>
                            <th>Produto</th>
                            <th class="text-center">Quantidade</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart->getCartProductsSession() as $product) { ?>
                            <tr>
                                <td><img class="cart-image" src="<?php url('/assets/images/iphone.jpg') ?>" alt=""></td>
                                <td><?php echo $product['name'] ?></td>
                                <td class="text-center">
                                    <?php if ($product['quantity'] > 1) { ?>
                                        <a class="btn btn-sm btn-outline-danger rounded-0 py-0 px-2" href="/cart-subtract?productId=<?php echo $product['id'] ?>">-</a>
                                        <span class="mx-2"><?php echo $product['quantity'] ?></span>
                                        <a class="btn btn-sm btn-outline-success rounded-0 py-0 px-2" href="/cart-add?productId=<?php echo $product['id'] ?>">+</a>
                                    <?php } else { ?>
                                        <span class="mx-2"><?php echo $product['quantity'] ?></span>
                                        <a class="btn btn-sm btn-outline-success rounded-0 py-0 px-2" href="/cart-add?productId=<?php echo $product['id'] ?>">+</a>
                                    <?php } ?>
                                </td>
                                <td><a class="btn btn-sm btn-danger rounded-1" href="/cart-remove?productId=<?php echo $product['id'] ?>"><i class="bi bi-trash"></i></a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <form class="col-12 col-md-6" action="/coupon-add" method="POST">
                <h3>Cupom de Desconto</h3>
                <div class="row">
                    <div class="col-12 col-md-7 mx-0 px-0">
                        <input type="text" class="form-control rounded-0" name="coupon" id="coupon" value="<?php if (isset($_SESSION['cart']['coupon'])) {
                            echo $_SESSION['cart']['coupon']['name'];
                        } ?>" autocomplete="off" placeholder="Insira o código..." />
                    </div>
                    <div class="col-12 col-md-5 mx-0 px-0">
                        <button class="btn btn-outline-primary rounded-0 col-12" type="submit">ADICIONAR</button>
                    </div>
                    <?php if (isset($_SESSION['cart']['coupon'])) { ?>
                        <div class="col-12 mx-0 px-0 mt-2">
                            <div class="alert alert-success rounded-0" role="alert">
                                Cupom <?php echo $_SESSION['cart']['coupon']['name'] ?> aplicado!
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <?php if (isset($_SESSION['errors'])) { ?>
                    <div class="row">
                        <div class="col-12 mt-2 mx-auto bg-danger text-white">
                            <?php foreach ($_SESSION['errors'] as $field => $error) { ?>
                                <ul>
                                    <li>
                                        <h4><?php echo $field ?></h4>
                                        <p><?php echo $error ?></p>
                                    </li>
                                </ul>
                            <?php }
                            unset($_SESSION['errors']) ?>
                        </div>
                    </div>
                <?php } ?>
            </form>
            <div class="col-12 col-md-6">
                <div class="row">
                    <div class="col-12">
                        <h4>Resumo do pedido</h4>
                    </div>
                    <div class="col-12">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td><strong>Total de produtos</strong></td>
                                    <td><?php echo $_SESSION['cart']['quantity'] ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Sub-total</strong></td>
                                    <td>R$<?php echo number_format($_SESSION['cart']['total'], 2, ',', '.') ?></td>
                                </tr>
                                <?php if (isset($_SESSION['cart']['coupon'])) { ?>
                                    <tr>
                                        <td><strong>Descontos</strong></td>
                                        <td>R$<?php echo number_format($_SESSION['cart']['discount'], 2, ',', '.') . ' (' . $_SESSION['cart']['coupon']['discount'] ?>%)</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Total</strong></td>
                                        <td>R$<?php echo number_format($_SESSION['cart']['total_payable'], 2, ',', '.') ?></td>
                                    </tr>
                                <?php } ?>

                            </tbody>
                        </table>
                    </div>
                    <form method="POST" action="/cart" class="col-12">
                        <button type="submit" class="btn btn-outline-success col-12 rounded-0">FINALIZAR</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
    </div>
    </div>
</section>