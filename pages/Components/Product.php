<div class="card rounded-1 mx-auto" style="width: 18rem;">
    <img src="<?php url('/assets/images/iphone.jpg') ?>" class="card-img-top p-3" alt="...">
    <div class="card-body">
        <h5 class="card-title"><?php echo $product->getName() ?></h5>
        <p class="card-text"><?php echo $product->getDescription() ?></p>
        <a href="/cart-store?productId=<?php echo $product->getId() ?>" class="btn btn-outline-success w-100 rounded-1">Adicionar ao carrinho</a>
    </div>
</div>