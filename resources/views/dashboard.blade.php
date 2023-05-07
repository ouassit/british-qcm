<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Tableau de bord') }}
        </h2>
    </x-slot>

    <div class="wrapper">

      <div class="box yellow">
         <h2><a href="{{ route('categories.index') }}">Categories</a></h2>
         <p>Categories management</p>
      </div>

      <div class="box" style="background-color: #b6e4a8">
         <h2><a href="{{ route('tests.index') }}">Tests</a></h2>
         <p>Test management</p>
      </div>

      <div class="box" style="background-color: #bbaaf7">
         <h2><a href="{{ route('questions.index') }}">Questions</a></h2>
         <p>Questions management</p>
      </div>

      <div class="box green">
         <h2><a href="{{ route('students_tests.index') }}">Students Tests</a></h2>
         <p>Results management</p>
      </div>

      <div class="box blue">
         <h2><a href="{{ route('settings.index') }}">Settings</a></h2>
         <p>Settings</p>
      </div>

   </div>
    

</x-app-layout>