<?php $this->assign('title', 'Sport Manager | Home'); ?>
<div id="myCarousel" class="carousel slide carousel-fade" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
        <div class="item active" id="background1">
            <div class="carousel-caption vmiddle">
                <h1>Welcome to Sportmanager</h1>
                <h4>The very first sport manager web application</h4>
            </div>
        </div>
        <div class="item" id="background2">
            <div class="carousel-caption">
                <h1>Rankings</h1>
                <h4>Compare your workout's logs to others</h4>
            </div>
        </div>
        <div class="item" id="background3">
            <div class="carousel-caption">
                <h1>Stickers</h1>
                <h4>Win loads of stickers and compare to other members</h4>
            </div>
        </div>
    </div>

    <!-- Controls -->
    <a class="left carousel-control" href="#myCarousel"  data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>


