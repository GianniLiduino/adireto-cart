<header>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12 d-flex align-items-center justify-content-around justify-content-md-evenly">
                <a class="text-decoration-none text-black" href="/"><h2><strong>Adireto - CART</strong></h2></a>
                <nav class="d-none d-sm-flex">
                    <ul class="list-unstyled">
                        <li><a class="btn nav-link" href="/">Produtos</a></li>
                    </ul>
                </nav>
                <?php if (isset($_SESSION['user'])) { ?>
                    <div class="align-items-center">
                        <a class="text-decoration-none position-relative me-3 cart" href="/cart">
                            <i class="bi bi-cart-fill"></i>
                            <span class="position-absolute top-0 start-100 translate-middle bg-danger text-white px-1 rounded-2"><?php echo $_SESSION['cart']['quantity'] ?></span>
                        </a>
                        <div class="btn-group">
                            <img class="image-profile rounded-circle dropdown-toggle" src="<?php url('/assets/images/person.jpg') ?>" alt="Perfil" data-bs-toggle="dropdown" aria-expanded="false">
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="/profile">Meu perfil</a></li>
                                <li><a class="dropdown-item" href="/logout">Sair <i class="bi bi-box-arrow-right"></i></a></li>
                            </ul>
                        </div>
                    </div>
                <?php } else { ?>
                    <div>
                        <a class="btn" href="/login">Entrar</a>
                        <a class="btn" href="/register">Registrar-se</a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</header>