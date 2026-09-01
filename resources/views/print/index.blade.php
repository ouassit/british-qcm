<style>
	.message {
      font-size: 18px;
      color: #333;
      margin-top: 20px;
      text-align: center;
    }
</style>

<div>
	<img style="width: 150px; height: 80px; float: left" src="{{$logo}}"/>
	<center><h1>{{$student_test->test->user->company}}</h1></center>
</div>
<center></center>
<center></center>
<br/>
<div style="background-color:  #e6e6e6; text-align: center;padding: 6px; font-size: 21px; font-weight: bold">
Placement Test Score
</div>
<br/>

<table width="100%">

	<tr>
		<td><b>Test Access Code : <b/></td><td>{{$student_test->access_code}}</td>
		<td><b>Test Date : <b/></td><td>{{$student_test->date}}</td>
	</tr>
	<tr>
		<td><b>First Name : <b/></td><td>{{$student_test->firstname}}</td>
		<td><b>Last Name : <b/></td><td>{{$student_test->lastname}}</td>
	</tr>
	<tr>
		<td><br/><b>Score : </b></td>
		<td colspan="2"><br/>{{$student_test->result}} / {{$student_test->test->total_questions}}</td>
	</tr>

	@php
		if(in_array($student_test->test->id, [49])) {
		    	$levels = ['Starter', 'Elementary', 'Pre-intermediate', 'Intermediate', 'Upper-intermediaite', 'Advanced'];
		    	$scores = [44, 66, 89, 104, 113, 120];

		    	$result = $student_test->result;

		    	$level = $levels[0]; // Par défaut Beginner

		    	foreach($scores as $index => $score){
		        	if($result <= $score){
		            	$level = $levels[$index];
		            	break;
		        	}
		    	}
		} else if(in_array($student_test->test->id, [50])){
			$levels = ['Starter 1 - A1', 'Starter 2 - A1+','Elementary A2','Pre-Intermediate B1', 'Intermediate B1+', 'Upper-Intermediate B2', 'Advanced C1', 'Proficiency C2'];
			$scores = [10, 20, 35, 55, 75, 90, 105, 115];

		    	$result = $student_test->result;

		    	$level = $levels[0]; // Par défaut Beginner

		    	foreach($scores as $index => $score){
		        	if($result <= $score){
		            	$level = $levels[$index];
		            	break;
		        	}
		    	}
		} else {
			$levels = ['Starter', 'Elementary', 'Pre-intermediate', 'Intermediate', 'Upper-intermediaite', 'Advanced'];
		    	$scores = [44, 66, 89, 104, 113, 120];

		    	$result = $student_test->result;

		    	$level = $levels[0]; // Par défaut Beginner

		    	foreach($scores as $index => $score){
		        	if($result <= $score){
		            	$level = $levels[$index];
		            	break;
		        	}
		    	}
		}
	@endphp


	<tr>
		<td><br/><b>Level : </b></td>
		<td colspan="2"><br/>{{$level}}</td>
	</tr>

</table>

<div class="message">
      Great job! Based on your results, we recommend enrolling in our <strong>{{$level}}</strong> course to continue improving your grammar, vocabulary, and fluency.
</div>

@if($correction)
<br/>

@if($student_test->test->user->print_category)

	

@else
	<table width='100%' border='1' style="font-size: 14px;">
		<tr>
			<th>N°</th>
			<th>Question</th>
			<th>Correct Answer</th>
			<th>Selected Answer</th>
			<th>Correct</th>
		</tr>
		@foreach($student_test->answers as $index => $question)
			<tr>
				<td>{!!$index+1!!}</td>
				<td>{!!$question->question!!}</td>
				<td>{{$question->correct_choice}}</td>
				<td>{{$question->selected_choice}}</td>
				<td style="text-align: center">
					@if($question->correct == 1)
					    <img style="width: 16px; height: 16px" src="{{ $true }}" />
					@elseif(empty($question->selected_choice))
					    
					@else
					    {{-- Question answered but incorrect --}}
					    <img style="width: 16px; height: 16px" src="{{ $false }}" />
					@endif
				</td>
			</tr>
		@endforeach
	</table>
	@endif

@endif



