<div id="header-carousel" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        @foreach ($data['carouselImages'] as $carouselImage )
        <div class="carousel-item {{ $loop->first ? 'active' : '' }}" style="height: 410px;">
            <img class="img-fluid" src="{{ asset('storage/' . $carouselImage->image) }}" alt="Image">
        </div>
            
        @endforeach
    </div>
    <a class="carousel-control-prev" href="#header-carousel" data-slide="prev">
        <div class="btn btn-dark" style="width: 45px; height: 45px;">
            <span class="carousel-control-prev-icon mb-n2"></span>
        </div>
    </a>
    <a class="carousel-control-next" href="#header-carousel" data-slide="next">
        <div class="btn btn-dark" style="width: 45px; height: 45px;">
            <span class="carousel-control-next-icon mb-n2"></span>
        </div>
    </a>
</div>
