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
Placement Test
</div>
<br/>

<table width="100%">

	<tr>
		<td><b>Test Access Code : <b/></td>
		<td>{{$student_test->access_code}}</td>
		<td><b>Test Date : <b/></td>
		<td>{{$student_test->date}}</td>
	</tr>
	<tr><td>&nbsp;</td><td></td><td></td><td></td></tr>
	<tr>
		<td><b>First Name : <b/></td>
		<td>{{$student_test->firstname}}</td>
		<td><b>Last Name : <b/></td>
		<td>{{$student_test->lastname}}</td>
	</tr>

</table>

<br/><br/>

@foreach($student_test->test->questions as $id1 => $question)
    <div class="question-block" style="margin-bottom: 20px;">
        	{{-- Question --}}
        	<div style="font-size: 16px; font-weight: bold; margin-bottom: 10px;">
            	{!! $question->question !!}
        	</div>

        	@php
		    $count = $question->choices->count();
		    $width = (int)(100 / max($count, 1));
		@endphp

        	<div style="display: flex; justify-content: space-around; align-items: center; width: 100%; margin: 0px;">
        		<table style="width: 100%; border-collapse: collapse;">
		            <tr>
		            	@foreach($question->choices as $id2 => $choice)
				        	
					      <td width="{{$width}}%" style="padding: 0px;">
					            <div style="display: inline-block; width: 16px; height: 16px; border: 1px solid #000;"></div>
					            {!! $choice->answer !!}
					      </td>
				      @endforeach
            		</tr>
		      </table>
        	</div>

    </div>
@endforeach





