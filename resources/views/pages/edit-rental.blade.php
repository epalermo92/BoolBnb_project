@extends('layouts.app')

@section('content')

  <div class="container">
    <div class="row">
      <div class="col-8 ml-col-2 writetoRental">
        <h1>Edit a home </h1>
          <form id="form" class="" action="{{ route('update.rental',$rental->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="form-group" >
              {{-- <label for="title">Title</label> --}}
              <input type="text" class="form-control {{$errors->has('title') ? "border-danger" : "" }}" name = "title" value="{{$rental->title}}">
              {!! $errors->first('title', '<small class="form-text text-danger">:message</small>') !!}
            </div>
            <div class="form-group" >
              {{-- <label for="description">Description</label> --}}
              <input type="text" class="form-control {{$errors->has('description') ? "border-danger" : "" }}" name = "description" value="{{$rental->description}}">
              {!! $errors->first('description', '<small class="form-text text-danger">:message</small>') !!}
            </div>
            <span class="form-group">
              {{-- <label for="rooms">Rooms</label> --}}
              <input type="number"  min="1" max="10" class="form-control form-numb1 {{$errors->has('rooms') ? "border-danger" : "" }}" name = "rooms" value="{{$rental->rooms}}">
                {!! $errors->first('rooms', '<small class="form-text text-danger">:message</small>') !!}
            </span>
            <span class="form-group">
              {{-- <label for="bedrooms">Beds</label> --}}
              <input type="number"  min="1" max="10" class="form-control form-numb2 {{$errors->has('bedrooms') ? "border-danger" : "" }}" name = "beds" value="{{$rental->beds}}">
                {!! $errors->first('beds', '<small class="form-text text-danger">:message</small>') !!}
            </span>
            <span class="form-group">
              {{-- <label for="bathrooms">Bathrooms</label> --}}
              <input type="number"  min="1" max="10" class="form-control form-numb1 {{$errors->has('bathrooms') ? "border-danger" : "" }}" name = "bathrooms" value={{$rental->bathrooms}}>
                {!! $errors->first('bathrooms', '<small class="form-text text-danger">:message</small>') !!}
            </span>
            <span class="form-group">
              {{-- <label for="square_meters">Surface (m<sup>2</sup>)</label> --}}
              <input type="number"  step="0.01" class="form-control form-numb2 {{$errors->has('square_meters') ? "border-danger" : "" }}" name = "square_meters" value="{{$rental->square_meters}}">
                {!! $errors->first('square_meters', '<small class="form-text text-danger">:message</small>') !!}
            </span>
            <div class="form-group service-form form-check pl-0" >
            {{-- <label for="services[]">Services</label> --}}
              <option value="" disabled selected>Choose the provided services</option>
              {!! $errors->first('services', '<small class="form-text text-danger">:message</small>') !!}
              <div class="service-container d-flex">
                @foreach ($services as $service)
                  <div class="d-flex mr-2 mb-2 item {{$rental->isService($service->id) ? "active" : ""}}">
                    <div class="d-flex align-items-center justify-content-center logo">
                      <i class="{{$service->icon}}"></i>
                    </div>
                    <div class="d-flex align-items-center check">
                      <input type="checkbox" class="service d-none" name="services[]" value="{{$service->id}}" {{$rental->isService($service->id) ? "checked" : ""}}> <label class="m-0 ml-1">{{ucfirst($service->name)}}  </label>
                    </div>


                  </div>
                @endforeach
              </div>
            </div>
            <div class="form-group mt-3" >
              {{-- <label for="address">Address</label> --}}
              {{-- <input type="text" class="form-control {{$errors->has('address') ? "border-danger" : "" }}" name = "address" placeholder="Enter Address">
              {!! $errors->first('address', '<small class="form-text text-danger">:message</small>') !!} --}}
              <div id="search-panel"></div>
              <input id="addr" type="hidden" name="address" value="{{$rental->address}}">
              <input id="lat" type="hidden" name="lat" value="{{$rental->lat}}">
              <input id="lon" type="hidden" name="lon" value="{{$rental->lon}}">
              <div id="mapE"></div>
            </div>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" >Upload</span>
              </div>
              <div class="custom-file">
                <input type="file" class="custom-file-input"  aria-describedby="image" name="image">
                <label class="custom-file-label" for="image">Select file</label>
              </div>
              {!! $errors->first('image', '<small class="form-text text-danger">:message</small>') !!}
            </div>
            <button type="submit" class="btn btn-primary">Edit rental</button>
          </form>
        </div>
    </div>
  </div>

  <script type="text/javascript">

    $(document).ready(

      function () {
        var latE = {{$rental->lat}};
        var lonE = {{$rental->lon}};

        var mapE = tomtom.L.map('mapE', {
          key: 'T1lAQG5AAAhzXmU8kZ5dB5zchnRTeyTG',
          center: [latE,lonE],
          zoom: 18
        });

        var searchBoxInstance = tomtom.searchBox({
              collapsible: false,
              searchOnDragEnd: 'never'
        }).addTo(mapE);


        var searchPanelE = $("#search-panel");

        searchPanelE.append(searchBoxInstance.getContainer());

        var initAddr = $("#addr").val();

        searchBoxInstance.search(initAddr);

        tomtom.fuzzySearch().query(initAddr).go(function (result) {

         var markers = new L.TomTomMarkersLayer().addTo(mapE);
         markers.setMarkersData([[latE,lonE]]);

         markers.addMarkers();
         map.fitBounds(markers.getBounds());
      });

    }

    );
  </script>

  <script type="text/javascript">

    $(document).ready(function(){

      $('.item').click(
        function(){

          $(this).toggleClass("active");

          var checkbox = $(this).find("input.service");

          if($(this).hasClass("active")){

            $(this).find("input.service").prop('checked', true);
          }
          else{
            $(this).find("input.service").prop('checked', false);


          }
        }
      );

    }
  );
</script>
@stop