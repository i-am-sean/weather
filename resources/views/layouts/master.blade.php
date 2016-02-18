<!DOCTYPE html>
<html lang="en">

<head>
  @include('includes.header')
  @section('customCSSScripts')
  @show
</head>

<body>
  <header>
    <!--	include "menu" -->
    @include('includes.menu')
  </header>
  <main>
    <div class="container">
      <div class="section">
        <div class="row">
          @section('mainContentSection') @show
        </div>
      </div>
      <br>
      <br>
      <div class="section">
      </div>
    </div>
  </main>
    @include('includes.fab-help')
    @include('includes.modals.help')
    @include('includes.modals.error')
    @include('includes.footer')
    @include('includes.scripts')
    @section('customJSScripts')
    @show

</body>

</html>
