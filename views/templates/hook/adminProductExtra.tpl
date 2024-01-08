<form method="post" action="{$link->getAdminLink('AdminProducts')|escape:'html':'UTF-8'}&id_product={$product}&updateproductage=1&token={$token}" name="formProductAge" id="formProductAge">
    <div class="form-group">
        <label class="form-control-label" for="min_age">Min age: </label>
        <input type="text" class="form-control" id="min_age" name="min_age_product" placeholder="min age">

        <label class="form-control-label" for="max_age">Max age: </label>
        <input type="text" class="form-control" id="max_age" name="max_age_product" placeholder="max age">

        <input type="hidden" value="{$product}" name="product">
    </div>
    <button class="btn btn-primary" name="submitFormAgeProduct" type="submit">Save</button>
</form>