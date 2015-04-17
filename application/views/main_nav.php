    <div class="container">
        <div class="header">
            <h1 class="brand-title"><a href="<?=base_url()?>">Hollywood Body Count</a></h1>
            <nav class="nav">
                <ul class="nav-list">
                    <?php 
                    foreach ($nav as $nav_item) {?>        
                    <li class="nav-item">
                        <a class="pure-button" href="<?=base_url().'index.php/main_template/page/'.$nav_item['cat_id'];?>"><?=$nav_item['cat_title'];?></a>
                    </li>
                    <?php } ?>
                </ul>
            </nav>
        </div>
    </div>