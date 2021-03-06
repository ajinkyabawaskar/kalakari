<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Ajinkya Bawaskar">
    <title>Add Product - Kalakari</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <!-- Favicons -->

    <meta name="theme-color" content="#563d7c">
    <link rel="stylesheet" href="style.css">
</head>

<body class="bg-light">
    <div class="container">
        <div class="py-5 text-center">
            <h2>Add Product</h2>
            <p class="lead">Fill in the product details.</p>
        </div>

        <div class="row">

            <div class="col-md-12">
                <form class="needs-validation" method="POST" id="addProductForm" novalidate="" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="product_price">Product Price</label>
                            <input type="number" class="form-control" id="product_price" name="product_price" placeholder="₹100 to ₹10000" required>
                            <div class="invalid-feedback">
                                Valid Product Price is required. (₹100 to ₹10000)
                            </div>
                        </div>
                        <div class="col-md-8 mb-3">
                            <label for="product_desc">Product Description</label>
                            <input type="text" class="form-control" id="product_desc" name="product_desc" placeholder="Describe your product here" required>
                            <div class="invalid-feedback">
                                Valid Product Description required. (Upto 25 characters)
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="product_avail2">Size Availability</label>
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="product_avail" value="In Stock" id="in-stock" required>
                                <label class="custom-control-label" for="in-stock">In Stock</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="product_avail" value="Out of Stock" id="out-of-stock" required>
                                <label class="custom-control-label" for="out-of-stock">Out of Stock</label>
                                <div class="invalid-feedback">
                                    Please select availability.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="product_color">Colors Available</label>
                            <select class="custom-select d-block w-100" id="product_color" name="product_color" required>
                                <option value="">Choose...</option>
                                <option value="aaa-000">Red</option>
                                <option value="bbb-000">Green</option>
                                <option value="ccc-000">Blue</option>
                                <option value="ddd-111">Orange</option>
                                <option value="eee-111">Black</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a valid color.
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="product_image">Upload Images</label>
                            <!-- <input type="text" class="form-control" id="zip" placeholder="" required=""> -->
                            <div class="input-group mb-2">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="product_image" name="product_image[]" multiple="multiple" required>
                                    <label class="custom-file-label" for="inputGroupFile01">Choose files</label>
                                </div>
                                <div class="invalid-feedback" id="file-error">
                                    Error.
                                </div>
                                <div class="invalid-feedback" id="file-info">

                                </div>

                            </div>
                            

                            <!-- <div id="progress-wrp">
                                <div class="progress-bar"></div>
                                <div class="status">0%</div>
                            </div> -->


                        </div>
                        
                    </div>
                    <hr class="my-4 mb-5">
                    <div class="row">
                        <div class="col-md-8">
                            <button class="btn btn-primary btn-lg btn-block" type="submit">Add Product to Inventory
                            </button>
                        </div>
                        <div class="col-md-4 alert alert-success text-center" id="alert_success" role="alert">
                            Product Added!
                        </div>
                        <div class="col-md-4 alert alert-danger text-center" id="alert_error" role="alert">
                            Product Not Added!
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <footer class="mb-5 pt-5 text-muted text-center text-small">
            <p class="mb-1">© Ajinkya Bawaskar</p>
            <ul class="list-inline">
                <li class="list-inline-item"><a href="https://github.com/ajinkyabawaskar/kalakari">View on GitHub</a></li>
                <li class="list-inline-item"><a href="https://ajinkya.space">ajinkya.space</a></li>
            </ul>
        </footer>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <script src="main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

</body>

</html>