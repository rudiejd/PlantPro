@extends('layouts.layout')
@section('content')
@php
	$plants = DB::table('Plant')->get();

@endphp


<div class="content text-center">
	<h1>Submit A Plant Sighting</h1>
	
    <form method="post" action="/submissions" enctype="multipart/form-data">
        @csrf
		<div class="form-row" id="row1">
		<input type="hidden" value="{{Auth::id()}}" name="userId" />
		<!-- plant id -->

		<div class="form-group col-md-12" id="plantId">
			<label for="plantId">Plant</label>
			</br>
			<select id="plantId" name="plantId" class="col-8 text-center" required>
				@foreach ($plants as $plant)
					<option value="{{$plant->plantId}}" class="text-center">{{$plant->commonName}}</option>
				@endforeach
			</select>
		</div>
		</div>
		<!-- title -->
		<div class="form-group col-md-12" id="description">
			<label for="description">Title</label>                                                                            
			<textarea class="form-control" id="descriptionIn" name="title" maxlength="150" required></textarea>
		</div>
		<!-- longitude (will remove later) -->
		<div class="form-group col-md-12" id="description">
			<label for="description">Longitude</label>
            <script type="application/javascript">
            function numberOnly(e) {
                var cCode = (e.which) ? e.which : event.keyCode
                if (cCode > 31 && (cCode < 48 || cCode > 57))
                return false;
                return true;
            } 
            </script>
			<textarea class="form-control" id="long" name="longitude" onkeypress="return numberOnly(event)" maxlength="12" required></textarea>
		</div>
		<!-- latitude (will remove later) -->
		<div class="form-group col-md-12" id="description">
            <label for="description">Latitude</label>
            <script type="application/javascript">
            function numberOnly(e) {
                var cCode = (e.which) ? e.which : event.keyCode
                if (cCode > 31 && (cCode < 48 || cCode > 57))
                return false;
                return true;
            }
            </script>
            <textarea class="form-control" id="lat" name="latitude" onkeypress="return numberOnly(event)" maxlength="12" required></textarea>
		</div>
			<div class="col-md-6">
			<label for="files[]">Select Photo:</label>
			<input type="file" name="image" /><br>
			<span class="text-muted">Note: Supported image format: .jpeg, .jpg, .png, .gif</span>
        </div>
   
		<div class="form-row" id="row3">
		<!-- description -->
		<div class="form-group col-md-12" id="description">
			<label for="description">Description</label>                                                                            
			<textarea class="form-control" id="descriptionIn" name="description" rows="5" cols="40" maxlength="150" required></textarea>
		</div>
		</div>
		
		<div id="buttons">
		<input type="hidden" name="cmd" value="submit">
		<input type="hidden" value="reset">
		<button type="submit" class="button">Submit</button>
		<button type="reset" class="button">Reset</button>
		</div>
		</form>
	  </div>
</div>

	<div id="map" style="height:200;"></div>
		<script>
			var mapCenter = [22, 87];
			var map = L.map('map');
			var googleHybrid = L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',{
    maxZoom: 20,
    subdomains:['mt0','mt1','mt2','mt3']
        }).addTo(map);

			var marker = L.marker(mapCenter).addTo(map);
			var updateMarker = function(lat, lng) {
    				marker.setLatLng([lat, lng]).bindPopup("Your location :  " + marker.getLatLng().toString().openPopup());
    				return false;
			};
			map.on('click', function(e) {
				$('#long').val(e.latlng.lng);
				$('#lat').val(e.latlng.lat);
				updateMarker(e.latlng.lat, e.latlng.lng);
			});
		</script>

	

</body>
@endsection
