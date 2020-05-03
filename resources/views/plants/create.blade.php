@extends('layouts.layout')
@section('content')

<div class="content text-center">
	<h1>Add a new plant</h1>
	

</div>
<!-- dont remove this form otherwise chrome wont render the other form thanks -jd -->
<form></form>
<div id="form">
		<form action="/plants" method="POST">
				@csrf
				<input type="hidden" name="userId" value="{{Auth::id()}}">
				<div class="form-row" id="row1">
				<!-- plant common name -->
					<div class="form-group col-md-6" id="name">
						<label for="plantNameIn">Common Name</label>
						<input type="text" class="form-control" id="plantNameIn" name="commonName" required />
					</div>
					<!-- division -->
					<div class="form-group col-md-6" id="division">
						<label for="divisionIn">Division</label>
						<input type="text" class="form-control" id="divisionIn" name="division" required />
					</div>
				</div>
				<div class="form-row" id="row2">
					<!-- class -->
					<div class="form-group col-md-6" id="class">
							<label for="classIn">Class</label>
							<input type="text" class="form-control" id="classIn" name="class" required />
					</div>
					<!-- order -->
					<div class="form-group col-md-6" id="order">
							<label for="orderIn">Order</label>                                                                                	
							<input type="text" class="form-control" id="orderIn" name="order" required />                               	
					</div>
				</div>
				<div class="form-row" id="row3">
					<!-- family -->
					<div class="form-group col-md-6" id="family">
							<label for="familyIn">Family</label>                                                                                    
							<input type="text" class="form-control" id="familyIn" name="family" required />
					</div>
					<!-- genus -->                                                                                                          
					<div class="form-group col-md-6" id="genus">
							<label for="genusIn">Genus</label>                                                                                      
							<input type="text" class="form-control" id="genusIn" name="genus" required />                                   
					</div>
				</div>
				<div class="form-row" id="row4">
					<!-- species -->
					<div class="form-group col-md-6" id="species">
									<label for="speciesIn">Species</label>                                                                                  
									<input type="text" class="form-control" id="speciesIn" name="species" required />			                
					</div>												                     	
					<!-- variety -->    
					<div class="form-group col-md-6" id="variety">
							<label for="varietyIn">Variety</label>                                                                                  
							<input type="text" class="form-control" id="varietyIn" name="variety" required />                                 
					</div>
				</div>
				
				<div id="buttons">
					<input type="hidden" name="cmd" value="submit" />
					<input type="hidden" value="reset" />
					<button type="submit" class="button">Submit</button>
					<button type="reset" class="button">Reset</button>
				</div>
		</form>
</div>

	

</body>
@endsection
