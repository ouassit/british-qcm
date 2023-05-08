
<div>
	<img style="width: 150px; height: 80px; float: left" src="{{$logo}}"/>
	<center><h1>{{$student_test->test->user->company}}</h1></center>
</div>
<center></center>
<center></center>
<br/>
<div style="background-color:  #e6e6e6; text-align: center;padding: 6px; font-size: 21px; font-weight: bold">
Test Result
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
		<td colspan="3"> <br/><b>Details</b></td>
	</tr>

	

	<tr>
		<td><br/><br/><b>Total result : </b></td>
		<td colspan="2"><br/><br/>{{$student_test->result}} / {{$student_test->test->total_questions}}</td>
	</tr>

</table>

@if($correction)
<br/><br/>
<table width='100%' border='1'>
	<tr>
		<th>Question</th>
		<th>Correct Answer</th>
		<th>Selected Answer</th>
		<th>Correct</th>
	</tr>
	@foreach($student_test->answers as $question)
		<tr>
			<td>{!!$question->question!!}</td>
			<td>{{$question->correct_choice}}</td>
			<td>{{$question->selected_choice}}</td>
			<td style="text-align: center">
				@if($question->correct==1)
				<img style="width: 16px; height: 16px" src="{{$true}}"/>
				@else
				<img style="width: 16px; height: 16px" src="{{$false}}"/>
				@endif
			</td>
		</tr>
	@endforeach
</table>
@endif



