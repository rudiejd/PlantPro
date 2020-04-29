@extends('layouts.layout')
@section('content')

<div class="content text-center">
	<h1>Submit A Plant Sighting</h1>
	
    <form method="post" action="{{ url('/submissions')}}" enctype="multipart/form-data">
        {{ csrf_field() }}
        @csrf
		<div class="form-row" id="row1">
		<!-- plant id -->
		<div class="form-group col-md-6" id="plantId">
			<label for="plantIDIn">Plant ID</label>
			<input type="text" class="form-control" id="plantIDIn" name="plantId" required>
		</div>
		<!-- user id -->
		<div class="form-group col-md-6" id="userId">
			<label for="userIDIn">User ID</label>
			<input type="text" class="form-control" id="userIDIn" name="userId" required>
		</div>
		</div>
		<!-- title -->
		<div class="form-group col-md-12" id="description">
			<label for="description">Title</label>                                                                            
			<textarea class="form-control" id="descriptionIn" name="title" required></textarea>
		</div>
		<!-- longitude (will remove later) -->
		<div class="form-group col-md-12" id="description">
			<label for="description">Longitude</label>                                                                            
			<textarea class="form-control" id="descriptionIn" name="longitude" required></textarea>
		</div>
		<!-- latitude (will remove later) -->
		<div class="form-group col-md-12" id="description">
			<label for="description">Longitude</label>                                                                            
			<textarea class="form-control" id="descriptionIn" name="latitude" required></textarea>
		</div>
		<div class="form-row" id="row3">
		<!-- description -->
		<div class="form-group col-md-12" id="description">
			<label for="description">Description</label>                                                                            
			<textarea class="form-control" id="descriptionIn" name="description" rows="5" cols="40" required></textarea>
		</div>
		</div>

		<!-- deane added -->
		<!-- submit an image -->
		<div class="form-row" id="row4">
			{{ csrf_field() }}
			<div class="form-group col-md-12">
				<table class="table">
					<tr>
						<td width="40%" align="right">
						<label>Select Plant Image for Upload</label></td>
						<td width="30"><input type="file" name="select_file"></td>
						<td width="30%" align="left"><span class="text-muted">These file types only: jpeg, jpg, png, or gif</span></td>
					</tr>
				</table>
			</div>
		</div>
		
		<div id="buttons">
		<input type="hidden" name="cmd" value="submit">
		<input type="hidden" value="reset">
		<button type="submit" name="upload" class="btn btn-primary">Submit</button>
		<button type="reset" class="btn btn-primary">Reset</button>
		</div>
		</form>
	  </div>
</div>


	

</body>
@endsection
