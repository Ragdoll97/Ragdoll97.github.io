<div class="row">
    <div class="col-md-12">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <?php
                $i = 0; 
                 foreach($sliders as $slider){
                        if($i == 0){
                ?>
                <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $i; ?>" class="active"></li>
                <?php
                $i++;  }else{
                if($i != 0){        
                ?>
                <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $i; ?>"></li>
                <?php               
                        } $i++;
                    }
                }
                ?> 
                
           
            </ol>
            <div class="carousel-inner">
                <?php 
                $i = 0;  
                foreach($sliders as $slider){
                    if($i == 0){
                ?>
                <div class="carousel-item active">
                    <img class="d-block w-100" src={{url('/uploads/'.$slider->file_path.'/'.$slider->file_name)}}  class="img-fluid img-responsive">
                </div>
                <?php               
                $i++;   } else{
                    if($i != 0){    
                ?>
                <div class="carousel-item ">
                    <img class="d-block w-100" src={{url('/uploads/'.$slider->file_path.'/'.$slider->file_name)}}   class="img-fluid img-responsive" alt="Second slide">
                </div>
                <?php                           
                        } $i++;
                    }  
                }
                ?>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Anterior</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Siguiente</span>
            </a>
        </div>
        
    </div>
</div>

