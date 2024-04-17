<div ng-model="ecommerceApp" ng-controller="BrandController">
    <h2 class="text-center">Insert Brands</h2>
    <form ng-submit="insertBrand()" class="mb-2">
        <div class="input-group w-90 mb-3">
            <span class="input-group-text bg-info" id="basic-addon1"><i class="fa-solid fa-receipt"></i></span>
            <input type="text" class="form-control" ng-model="brandName" placeholder="Insert Brands" aria-label="Brands" aria-describedby="basic-addon1">
        </div>
        <div class="input-group w-10 mb-2 m-auto">
            <input type="submit" class="bg-info border-0 p-2 my-2" value="Insert Brands">
        </div>
    </form>
</div>