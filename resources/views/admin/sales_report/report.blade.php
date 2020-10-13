<div class="row">
    <h5>Sales Report</h5>
    <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="panel content__box content__box--shadow">
            <div class="text-center">
                <div>Total Order</div>
                <div class="huge">{{ $totalOrder }}</div>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="panel content__box content__box--shadow">
            <div class="text-center">
                <div>SubTotal</div>
                <div class="huge">{{ $subTotalOrder }}</div>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="panel content__box content__box--shadow">
            <div class="text-center">
                <div>Taxes</div>
                <div class="huge">{{ $totalTax }}</div>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="panel content__box content__box--shadow">
            <div class="text-center">
                <div>Shipping</div>
                <div class="huge">{{ $totalShipping }}</div>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="panel content__box content__box--shadow">
            <div class="text-center">
                <div>Discount</div>
                <div class="huge">{{ $totalDiscount }}</div>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="panel content__box content__box--shadow">
            <div class="text-center">
                <div>Total Sales</div>
                <div class="huge">{{ $grandTotal }}</div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <h5>Sales Report Details</h5>
    <div class="col-md-12 content__box content__box--shadow">
        <table id="myTable" class="table table-striped table-hover">
            <thead>
            <tr>
                <th>SN</th>
                <th>Name</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Shipping</th>
                <th>Discount</th>
                <th>Grand Total</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
            <tr>
                <th>SN</th>
                <th>Name</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Shipping</th>
                <th>Discount</th>
                <th>Grand Total</th>
            </tr>
            </tfoot>
        </table>
    </div>
</div>

