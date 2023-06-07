<?php
$materials = AppData::material;
?>
<div class="shop_sidebar_area">

    <!-- ##### Single Widget ##### -->
    <div class="widget catagory mb-50">
        <!-- Widget Title -->
        <h6 class="widget-title mb-30">Danh mục sản phẩm</h6>

        <!--  Catagories  -->
        <div class="catagories-menu">
            <ul>
                @foreach ($cat as $item)
                    <li><a href="{{route('product-list',['cat' => $item->cat_id])}}">{{ $item->cat_name }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- ##### Single Widget ##### -->
    <div class="widget brands mb-50">
        <!-- Widget Title -->
        <h6 class="widget-title mb-30">Chất liệu</h6>
        <div class="catagories-menu">

            <!-- Single Form Check -->
            <ul>
                @foreach ($materials as $key => $material)
                    <li><a href="{{route('product-list',['material' => $key])}}">{{ $material }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="widget catagory mb-50">
        <!-- Widget Title -->
        <h6 class="widget-title mb-30">Collection</h6>

        <!--  Catagories  -->
        <div class="catagories-menu">
            <ul>
                @foreach ($col as $item)
                    <li><a href="{{route('product-list',['col' => $item->collect_id])}}">{{ $item->collect_name }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- #### Start Collapse Menu ####-->
    <div class="accordion" id="accordionExample">
        <div class="card">
            <div class="card-header" id="headingOne">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                        data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        <!-- Widget Title -->
                        <h6 class="widget-title mb-30">Danh mục sản phẩm</h6>
                    </button>
                </h2>
            </div>

            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                <div class="card-body">
                    <div class="catagories-menu">
                        <ul>
                            @foreach ($cat as $item)
                                <li><a href="{{route('product-list',['cat' => $item->cat_id])}}">{{ $item->cat_name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="headingTwo">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse"
                        data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        <h6 class="widget-title mb-30">Chất liệu</h6>
                    </button>
                </h2>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                <div class="card-body">
                    <ul>
                        @foreach ($materials as $key => $material)
                            <li><a href="{{route('product-list',['material' => $key])}}">{{ $material }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="headingOne">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                        data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        <!-- Widget Title -->
                        <h6 class="widget-title mb-30">Collection</h6>
                    </button>
                </h2>
            </div>

            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                <div class="card-body">
                    <div class="catagories-menu">
                        <ul>
                            @foreach ($col as $item)
                                <li><a href="{{route('product-list',['col' => $item->collect_id])}}">{{ $item->collect_name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #### End Collapse Menu ####-->
</div>
