@extends('layouts.base')
@section('content')
<style>
  .dropdown {
      position: relative;
      display: inline-block;
  }

  .dropdown-content {
      display: none;
      position: absolute;
      background-color: #f9f9f9;
      box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
      border-radius: 3px;
      padding: 5px 5px;
      z-index: 1;
      width: fit-content;
      right:10px;
  }
  .dropdown:hover .dropdown-content {
      display: block;
  }

  .container-panel{
    display: grid;
    width: 1fr;
    grid-template-columns: repeat(4, 1fr);
    grid-gap: 1em;
    padding-top: 20px;
  }

  .button-panel{
    padding: 10px;
    text-align: center;
    cursor: pointer;
    background-color: white;
    color: black;
    font-size: 1em;
    border-radius: 5px;
    box-shadow: 1px 1px 1px #333;
    transition: .2s;
    height: 40px;
  }

  @media (min-width: 1200px){
    .col-xl-3 {
        flex: 0 0 auto;
        width: 30%;
    }
  }
  @media (max-width: 800px){
    .col-md-6 {
        width: 70%;
    }
  }
  @media (max-width: 500px){
    .col-md-6 {
        width: 100%;
    }
  }
</style>
<head>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
  <link href="/assets/css/create-bracelet.css" rel="stylesheet">
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <link href="https://fonts.cdnfonts.com/css/low-gun-screen" rel="stylesheet">

  <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.18/dist/js/bootstrap-select.min.js"></script>

</head>

  <!-- ======= Breadcrumbs ======= -->
  <div class="breadcrumbs" id="mainSec">
    <div class="page-header d-flex align-items-center" style="background-image: url('');">
      <div class="container position-relative">
        <div class="row d-flex justify-content-center">
          <div class="col-lg-6 text-center">
            <h2>Create Your Own Custom Bracelet</h2>
            <p>Build your bracelet in a few steps and see how it would look</p>
          </div>
        </div>
      </div>
    </div>
    <nav>
      <div class="container">
        <ol>
          <li><a style="color:#909291; font-weight:normal;" href="/">Home</a></li>
          <li style="font-weight:normal;">Create</li>
        </ol>
      </div>
    </nav>
  </div><!-- End Breadcrumbs -->

  <!-- bracelets type options -->
  <section id="hero" class="hero" style="background-color: white; padding: 0px; margin-bottom:50px">
      <div class="container position-relative">
        <div class="center" style="margin-top:30px; margin-bottom: -30px;">
          <h1 class="shop-title border-line center" id="chooseType">Choose The Type</h1>
        </div>
        <div class="row gy-4 mt-5 justify-content-center" style="text-align: center;">

          <!-- option 1 -->
          <div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-delay="50" id="option1">
            <div class="icon-box" onclick="selectBraceletType('option1')" style="background-image: url(assets/img/bracelets-examples/classic_1.png); background-size: 390px 200px; background-repeat: no-repeat; height: 200px;">
              <h4 class="title font-outline"><a class="stretched-link" id="classic">Classic</a></h4>
              <a class="stretched-link font-outline" style="color: white;">(Starting from $12)</a>
            </div>
          </div>

          <!-- option 2 -->
          <div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-delay="50" id="option2">
            <div class="icon-box" onclick="selectBraceletType('option2')" style="background-image: url(assets/img/bracelets-examples/unicolor_1.png); background-size: 390px 200px; background-repeat: no-repeat; height: 200px;">
              <div class="product-tag">Online exclusive!</div>          
              <h4 class="title font-outline"><a class="stretched-link id="unicolor">Unicolor</a></h4>
              <a class="stretched-link font-outline" style="color: white;">(Starting from $14)</a>
            </div>
          </div>

        </div>
      </div>
  </section>

  <!-- Form bracelet creator -->
  <div class="formbold-form-wrapper" id="formSec" name="details" style="display:none; margin-top:-50px">
    <!-- <img src="your-image-url-here.jpg"> -->
    <form method="POST" action="{{url('store-bracelet')}}" enctype="multipart/form-data">
    @csrf

      <!-- Here goes the type -->
      <input  type="text" name="type" id="typeField" value="" style="display: none;"/>

      <!-- Here goes the price -->
      <input  type="text" name="price" id="priceField" value="" style="display: none;"/>

      <!-- Option for sizes -->
      <div class="formbold-input-radio-wrapper" id="sizesSection">
        <Table>
          <th>
            <label for="ans" class="formbold-form-label"> <b>Choose the size of your bracelet</b></label>
          </th>
          <th>
            <span class="hovertext" data-hover="The average size for a teen or an adult is medium">
              <i class="fa fa-question-circle" style="margin-bottom: 12px; margin-left:5px;"></i> 
            </span>
          </th>
        </Table>

        <div class="formbold-radio-flex">

          <div class="formbold-radio-group">
            <label class="formbold-radio-label">
              <input class="formbold-input-radio" type="radio" name="size" id="size1" value="small" required/> Small (babys & kids)  <span class="formbold-radio-checkmark"></span>
            </label>
          </div>

          <div class="formbold-radio-group">
            <label class="formbold-radio-label">
              <input class="formbold-input-radio" type="radio" name="size" id="size2" value="medium" required/> Medium (youth & adults)<span class="formbold-radio-checkmark"></span>
            </label>
          </div>

          <div class="formbold-radio-group">
            <label class="formbold-radio-label">
              <input class="formbold-input-radio" type="radio" name="size" id="size3" value="large" required/> Large (thick wrist)<span class="formbold-radio-checkmark"></span>
            </label>
          </div>

        </div>
      </div>

      <!-- Here goes the name or phrase -->
      <div class="formbold-input-group" id="nameSection" style="display: none;">
        <Table>
          <th>
            <label for="name" class="formbold-form-label" id="nameLabel"> <b>Name or phrase</b></label>
          </th>
          <th>
            <span class="hovertext" data-hover="Characters may include numbers, letters and symbols such  as: .!#+'=<>-♡">
              <i class="fa fa-question-circle" style="margin-bottom: 12px; margin-left:5px;"></i> 
            </span>
          </th>
        </Table>

        <table style="width: 110%;">
          <th>
            <input  type="text" name="name" id="nameField" placeholder="Enter the name or phrase" class="formbold-form-input" style="text-transform:uppercase" onpaste="return false;" ondrop="return false;" autocomplete="off" required/>
          </th>
          <th>
            <div class="dropdown">
              <a class="formbold-btn" style="background-color: #198754;"><i class="fa fa-plus-circle"></i></a>
              <div class="dropdown-content">
                <p>Characters alowed:</p>
                <div class="container-panel">
                  <div class="button-panel" onclick="setCharacter('#')">#</div>
                  <div class="button-panel" onclick="setCharacter('!')">!</div>
                  <div class="button-panel" onclick="setCharacter('.')">.</div>
                  <div class="button-panel" onclick="setCharacter('+')">+</div>
                  <div class="button-panel" onclick="setCharacter('\'')">'</div>
                  <div class="button-panel" onclick="setCharacter('-')">-</div>
                  <div class="button-panel" onclick="setCharacter('[')">[</div>
                  <div class="button-panel" onclick="setCharacter(']')">]</div>
                  <div class="button-panel" onclick="setCharacter('_')">_</div>
                  <div class="button-panel" onclick="setCharacter('=')">=</div>
                  <div class="button-panel" onclick="setCharacter(':')">:</div>
                  <div class="button-panel" onclick="setCharacter('❤')">❤</div>
                </div>
              </div>
            </div>
          </th>
        </table>
      </div>

      <!-- color number options -->
      <div class="formbold-input-radio-wrapper" id="colorsSection" style="display: none;">
        <label for="ans" class="formbold-form-label">
        <b>Choose how many colors you want for your bracelet</b>
        </label>

        <div class="formbold-radio-flex">


          <div class="formbold-radio-group">
            <label class="formbold-radio-label">
              <input class="formbold-input-radio" type="radio" name="color" id="ans1" required/>
              <p id="price1">One color ($10)</p>
              <span class="formbold-radio-checkmark"></span>
            </label>
          </div>

              <!-- Colors options -->
              <div class="select-container op1" id="op1" style="display: none;">
                <label class="formbold-form-label">Color</label>
                <div class="select select1">
                    <input type="text" id="input1" name="color_full" placeholder="select" onfocus="this.blur();">                    
                </div>
                <div class="option-container optionContainer1">
                    <div class="option options1"> <label> Red </label> <i class="fa fa-square position" style="color:#Bf072d;"></i> </div>
                    <div class="option options1"> <label> Green </label> <i class="fa fa-square position" style="color:#03810b;"></i> </div>
                    <div class="option options1"> <label> Light green </label> <i class="fa fa-square position" style="color:#07EC27;"></i> </div>
                    <div class="option options1"> <label> Pink </label> <i class="fa fa-square position" style="color:pink;"></i> </div>
                    <div class="option options1"> <label> Dark pink </label> <i class="fa fa-square position" style="color:#B70788;"></i> </div>
                    <div class="option options1"> <label> Yellow </label> <i class="fa fa-square position" style="color:yellow;"></i> </div>
                    <div class="option options1"> <label> Blue </label> <i class="fa fa-square position" style="color:#296ae2;"></i> </div>
                    <div class="option options1"> <label> Dark blue </label> <i class="fa fa-square position" style="color:blue;"></i> </div>
                    <div class="option options1"> <label> Purple</label> <i class="fa fa-square position" style="color:#6d1ed0;"></i> </div>
                    <div class="option options1"> <label> black </label> <i class="fa fa-square position" style="color:#000000;"></i> </div>

                </div>
              </div>

          <div class="formbold-radio-group">
            <label class="formbold-radio-label">
              <input class="formbold-input-radio" type="radio" name="color" id="ans2" required/>
              <p id="price2">One color ($12)</p>
              <span class="formbold-radio-checkmark"></span>
            </label>
          </div>

              <!-- Colors options -->
              <div class="select-container op2" id="op2" style="display: none;">
                <label class="formbold-form-label">Color 1 (sides)</label>
                <div class="select select2">
                    <input type="text" id="input2" name="color_sides" placeholder="select" onfocus="this.blur();">
                </div>
                <div class="option-container">
                    <div class="option options2"> <label> Red </label> <i class="fa fa-square position" style="color:#Bf072d;"></i> </div>
                    <div class="option options2"> <label> Green </label> <i class="fa fa-square position" style="color:#03810b;"></i> </div>
                    <div class="option options2"> <label> Light green </label> <i class="fa fa-square position" style="color:#07EC27;"></i> </div>
                    <div class="option options2"> <label> Pink </label> <i class="fa fa-square position" style="color:pink;"></i> </div>
                    <div class="option options2"> <label> Dark pink </label> <i class="fa fa-square position" style="color:#B70788;"></i> </div>
                    <div class="option options2"> <label> Yellow </label> <i class="fa fa-square position" style="color:yellow;"></i> </div>
                    <div class="option options2"> <label> Blue </label> <i class="fa fa-square position" style="color:#296ae2;"></i> </div>
                    <div class="option options2"> <label> Dark blue </label> <i class="fa fa-square position" style="color:blue;"></i> </div>
                    <div class="option options2"> <label> Purple</label> <i class="fa fa-square position" style="color:#6d1ed0;"></i> </div>
                    <div class="option options2"> <label> black </label> <i class="fa fa-square position" style="color:#000000;"></i> </div>
                    
                </div>
              </div>

              <!-- Colors options -->
              <div class="select-container op3" id="op3" style="display: none;">
                <label class="formbold-form-label">Color 2 (center)</label>
                <div class="select select3">
                    <input type="text" id="input3" name="color_center" placeholder="select" onfocus="this.blur();">
                </div>
                <div class="option-container">
                    <div class="option options3"> <label> Red </label> <i class="fa fa-square position" style="color:#Bf072d;"></i> </div>
                    <div class="option options3"> <label> Green </label> <i class="fa fa-square position" style="color:#03810b;"></i> </div>
                    <div class="option options3"> <label> Light green </label> <i class="fa fa-square position" style="color:#07EC27;"></i> </div>
                    <div class="option options3"> <label> Pink </label> <i class="fa fa-square position" style="color:pink;"></i> </div>
                    <div class="option options3"> <label> Dark pink </label> <i class="fa fa-square position" style="color:#B70788;"></i> </div>
                    <div class="option options3"> <label> Yellow </label> <i class="fa fa-square position" style="color:yellow;"></i> </div>
                    <div class="option options3"> <label> Blue </label> <i class="fa fa-square position" style="color:#296ae2;"></i> </div>
                    <div class="option options3"> <label> Dark blue </label> <i class="fa fa-square position" style="color:blue;"></i> </div>
                    <div class="option options3"> <label> Purple</label> <i class="fa fa-square position" style="color:#6d1ed0;"></i> </div>
                    <div class="option options3"> <label> black </label> <i class="fa fa-square position" style="color:#000000;"></i> </div>
                    
                </div>
              </div>


          <div class="formbold-radio-group">
            <label class="formbold-radio-label">
              <input class="formbold-input-radio" type="radio" name="color" id="ans3" required/>
              <p id="price3">One color ($14)</p>
              <span class="formbold-radio-checkmark"></span>
            </label>
          </div>

              <!-- Colors options -->
              <div class="select-container op4" id="op4" style="display: none;">
                <label class="formbold-form-label">Color 1 (left side)</label>
                <div class="select select4">
                    <input type="text" id="input4" name="color_left" placeholder="select" onfocus="this.blur();">
                </div>
                <div class="option-container">
                    <div class="option options4"> <label> Red </label> <i class="fa fa-square position" style="color:#Bf072d;"></i> </div>
                    <div class="option options4"> <label> Green </label> <i class="fa fa-square position" style="color:#03810b;"></i> </div>
                    <div class="option options4"> <label> Light green </label> <i class="fa fa-square position" style="color:#07EC27;"></i> </div>
                    <div class="option options4"> <label> Pink </label> <i class="fa fa-square position" style="color:pink;"></i> </div>
                    <div class="option options4"> <label> Dark pink </label> <i class="fa fa-square position" style="color:#B70788;"></i> </div>
                    <div class="option options4"> <label> Yellow </label> <i class="fa fa-square position" style="color:yellow;"></i> </div>
                    <div class="option options4"> <label> Blue </label> <i class="fa fa-square position" style="color:#296ae2;"></i> </div>
                    <div class="option options4"> <label> Dark blue </label> <i class="fa fa-square position" style="color:blue;"></i> </div>
                    <div class="option options4"> <label> Purple</label> <i class="fa fa-square position" style="color:#6d1ed0;"></i> </div>
                    <div class="option options4"> <label> black </label> <i class="fa fa-square position" style="color:#000000;"></i> </div>
                    
                </div>
              </div>

              <!-- Colors options -->
              <div class="select-container op5" id="op5" style="display: none;">
                <label class="formbold-form-label">Color 2 (center)</label>
                <div class="select select5">
                    <input type="text" id="input5" name="color_center" placeholder="select" onfocus="this.blur();">
                </div>
                <div class="option-container">
                    <div class="option options5"> <label> Red </label> <i class="fa fa-square position" style="color:#Bf072d;"></i> </div>
                    <div class="option options5"> <label> Green </label> <i class="fa fa-square position" style="color:#03810b;"></i> </div>
                    <div class="option options5"> <label> Light green </label> <i class="fa fa-square position" style="color:#07EC27;"></i> </div>
                    <div class="option options5"> <label> Pink </label> <i class="fa fa-square position" style="color:pink;"></i> </div>
                    <div class="option options5"> <label> Dark pink </label> <i class="fa fa-square position" style="color:#B70788;"></i> </div>
                    <div class="option options5"> <label> Yellow </label> <i class="fa fa-square position" style="color:yellow;"></i> </div>
                    <div class="option options5"> <label> Blue </label> <i class="fa fa-square position" style="color:#296ae2;"></i> </div>
                    <div class="option options5"> <label> Dark blue </label> <i class="fa fa-square position" style="color:blue;"></i> </div>
                    <div class="option options5"> <label> Purple</label> <i class="fa fa-square position" style="color:#6d1ed0;"></i> </div>
                    <div class="option options5"> <label> black </label> <i class="fa fa-square position" style="color:#000000;"></i> </div>
                    
                </div>
              </div>

              <!-- Colors options -->
              <div class="select-container op6" id="op6" style="display: none;">
                <label class="formbold-form-label">Color 3 (right side)</label>
                <div class="select select6">
                    <input type="text" id="input6" name="color_right" placeholder="select" onfocus="this.blur();">
                </div>
                <div class="option-container">
                    <div class="option options6"> <label> Red </label> <i class="fa fa-square position" style="color:#Bf072d;"></i> </div>
                    <div class="option options6"> <label> Green </label> <i class="fa fa-square position" style="color:#03810b;"></i> </div>
                    <div class="option options6"> <label> Light green </label> <i class="fa fa-square position" style="color:#07EC27;"></i> </div>
                    <div class="option options6"> <label> Pink </label> <i class="fa fa-square position" style="color:pink;"></i> </div>
                    <div class="option options6"> <label> Dark pink </label> <i class="fa fa-square position" style="color:#B70788;"></i> </div>
                    <div class="option options6"> <label> Yellow </label> <i class="fa fa-square position" style="color:yellow;"></i> </div>
                    <div class="option options6"> <label> Blue </label> <i class="fa fa-square position" style="color:#296ae2;"></i> </div>
                    <div class="option options6"> <label> Dark blue </label> <i class="fa fa-square position" style="color:blue;"></i> </div>
                    <div class="option options6"> <label> Purple</label> <i class="fa fa-square position" style="color:#6d1ed0;"></i> </div>
                    <div class="option options6"> <label> black </label> <i class="fa fa-square position" style="color:#000000;"></i> </div>
                    
                </div>
              </div>

        </div>
      </div>

      <!-- optional message text box -->
      <div id="messageSection" style="display: none;">
        <label for="message" class="formbold-form-label">
          <b>Any other specification (optional)</b>
        </label>
        <textarea rows="4" name="message" id="message" placeholder="Type here..." class="formbold-form-input"></textarea>
      </div>

      <!-- Buttton to generate bracelet preview -->
      <div class="formbold-btn" id="generateBraceletButton" style="background-color:black; display:none;" onclick="generateBracelet()">Preview your bracelet</div>

      <!-- bracelet preview -->
      <div id="braceletPreviewSection" style="display: none; position:relative">
        <br>
        <Table>
          <th>
            <label for="bracelet" class="formbold-form-label" id="braceletLAbel"> <b>Preview:</b> </label>
          </th>
          <th>
            <span class="hovertext" data-hover="This is just a preview of the actual bracelet. The real one might not look exactly the same.">
              <i class="fa fa-question-circle" style="margin-bottom: 12px; margin-left:5px;"></i> 
            </span>
          </th>
        </Table>

        <div name="bracelet" id="braceletContainer" class="bracelet-container"></div>
        <div id="braceletContainerHidden" class="bracelet-container-hidden"></div>

      </div>

      <!-- Quantity button -->
      <div id='quantityBtn' class='quantity' style='display:none;'>
        <br>
        <label for="message" class="formbold-form-label">
          <b>Quantity (How many bracelets you want):</b>
        </label>
        <div class="center">
          <input type='button' value='-' class='qtyminus minus' field='quantity' />
          <input type='number' id="quantityInput" name='quantity' value='1' data-max="120" pattern="[0-9]*" class='qty' />
          <input type='button' value='+' class='qtyplus plus' field='quantity' />
        </div>
      </div>

      <input type="text" name="bracelet_image" id="bracelet_image" style="display:none;"/>
      
      <!-- Submit & reset button -->
      <table class="container">
        <th>
          <div class="formbold-btn" id="resetProcessBtn" style="background-color:black; display:none;" onclick="resetProcess()">Restart <span class="fa fa-refresh" style="color: white;"><span/> </div>
        </th>
        <th style="width: 10px;"></th>
        <th>
          <button class="formbold-btn" id="submitBtn"  style="background-color:black; display:none;" type="submit" onclick="validateQuantity()">Add to cart <span class="fa fa-shopping-cart" style="color: white;"><span/> </button>
        </th>
      </table>

    </form>
  </div>
</div>



<script>
  
  $(document).ready(function(){
  });

  var svgObjectID;
  var svgObjectIdHidden;

  function selectBraceletType(option){

    if(option == 'option1'){
      $("#option2").hide();
      $("#formSec").show();
      $("#typeField").val('classic')
      $("#price1").text('One color ($12)');
      $("#price2").text('Two colors ($14)');
      $("#price3").text('Three colors ($16)');

    }else if(option == 'option2'){
      $("#option1").hide();
      $("#formSec").show();
      $("#typeField").val('unicolor')
      $("#price1").text('One color ($14)');
      $("#price2").text('Two colors ($16)');
      $("#price3").text('Three colors ($18)');
    }
    // changes the main title: Choose the type
    $("#chooseType").text("Let's build your bracelet");  
  }

  function generateBracelet(){
    // checks for validations before generating bracelet
    if(checkValidations()){
      $svg = $(svgObjectID);
      $svg2 = $(svgObjectIdHidden);

      // Sets the name on bracelet
      var nameField = $('#nameField').val();
      $('#MAIN_NAME', $svg).text(nameField);
      $('#MAIN_NAME', $svg2).text(nameField.toUpperCase());

      // Sets the colors on bracelet
      let colors = getSelectedcolors();
      let colorsForm = getSelectedcolorsForm();

      if(colors.length == 1){
        $("#LEFT_SIDE_1", $svg).attr('style', "fill:" + colors[0]);
        $("#LEFT_SIDE_2", $svg).attr('style', "fill:" + colors[0]);
        $("#COVER2", $svg).attr('style', "fill:" + colors[0]);
        $("#CENTER_BENDED", $svg).attr('style', "fill:" + colors[0]);
        $("#COVER1", $svg).attr('style', "fill:" + colors[0]);
        $("#RIGHT_SIDE_1", $svg).attr('style', "fill:" + colors[0]);
        $("#RIGHT_SIDE_2", $svg).attr('style', "fill:" + colors[0]);

        $("#LEFT_SIDE_1", $svg2).attr('style', "fill:" + colors[0]);
        $("#LEFT_SIDE_2", $svg2).attr('style', "fill:" + colors[0]);
        $("#COVER2", $svg2).attr('style', "fill:" + colors[0]);
        $("#CENTER_BENDED", $svg2).attr('style', "fill:" + colors[0]);
        $("#COVER1", $svg2).attr('style', "fill:" + colors[0]);
        $("#RIGHT_SIDE_1", $svg2).attr('style', "fill:" + colors[0]);
        $("#RIGHT_SIDE_2", $svg2).attr('style', "fill:" + colors[0]);

        //creates a json with the colors
        var obj = new Object();
        obj.colors_number = "1";
        obj.color_full  = colorsForm[0];
        var jsonString = JSON.stringify(obj);
        $("[name='color']").val(jsonString);

        //sets the price
        if($("#typeField").val() === 'classic'){
          $('#priceField').val('12');
        }else{
          $('#priceField').val('14');
        }
        

      }else if(colors.length == 2){
        $("#LEFT_SIDE_1", $svg).attr('style', "fill:" + colors[0]);
        $("#LEFT_SIDE_2", $svg).attr('style', "fill:" + colors[0]);
        $("#COVER2", $svg).attr('style', "fill:" + colors[0]);
        $("#CENTER_BENDED", $svg).attr('style', "fill:" + colors[1]);
        $("#COVER1", $svg).attr('style', "fill:" + colors[0]);
        $("#RIGHT_SIDE_1", $svg).attr('style', "fill:" + colors[0]);
        $("#RIGHT_SIDE_2", $svg).attr('style', "fill:" + colors[0]);

        $("#LEFT_SIDE_1", $svg2).attr('style', "fill:" + colors[0]);
        $("#LEFT_SIDE_2", $svg2).attr('style', "fill:" + colors[0]);
        $("#COVER2", $svg2).attr('style', "fill:" + colors[0]);
        $("#CENTER_BENDED", $svg2).attr('style', "fill:" + colors[1]);
        $("#COVER1", $svg2).attr('style', "fill:" + colors[0]);
        $("#RIGHT_SIDE_1", $svg2).attr('style', "fill:" + colors[0]);
        $("#RIGHT_SIDE_2", $svg2).attr('style', "fill:" + colors[0]);

        var obj = new Object();
        obj.colors_number = "2";
        obj.color_sides  = colorsForm[0];
        obj.color_center  = colorsForm[1];
        var jsonString = JSON.stringify(obj);
        $("[name='color']").val(jsonString);

        //sets the price
        if($("#typeField").val() === 'classic'){
          $('#priceField').val('14');
        }else{
          $('#priceField').val('16');
        }

      }else if(colors.length == 3){
        $("#LEFT_SIDE_1", $svg).attr('style', "fill:" + colors[0]);
        $("#LEFT_SIDE_2", $svg).attr('style', "fill:" + colors[0]);
        $("#COVER2", $svg).attr('style', "fill:" + colors[0]);
        $("#CENTER_BENDED", $svg).attr('style', "fill:" + colors[1]);
        $("#COVER1", $svg).attr('style', "fill:" + colors[2]);
        $("#RIGHT_SIDE_1", $svg).attr('style', "fill:" + colors[2]);
        $("#RIGHT_SIDE_2", $svg).attr('style', "fill:" + colors[2]);

        $("#LEFT_SIDE_1", $svg2).attr('style', "fill:" + colors[0]);
        $("#LEFT_SIDE_2", $svg2).attr('style', "fill:" + colors[0]);
        $("#COVER2", $svg2).attr('style', "fill:" + colors[0]);
        $("#CENTER_BENDED", $svg2).attr('style', "fill:" + colors[1]);
        $("#COVER1", $svg2).attr('style', "fill:" + colors[2]);
        $("#RIGHT_SIDE_1", $svg2).attr('style', "fill:" + colors[2]);
        $("#RIGHT_SIDE_2", $svg2).attr('style', "fill:" + colors[2]);

        var obj = new Object();
        obj.colors_number = "3";
        obj.color_left  = colorsForm[0];
        obj.color_center  = colorsForm[1];
        obj.color_right  = colorsForm[2];
        var jsonString = JSON.stringify(obj);
        $("[name='color']").val(jsonString);
        
        //sets the price
        if($("#typeField").val() === 'classic'){
          $('#priceField').val('16');
        }else{
          $('#priceField').val('18');
        }
      }

      // Display bracelet
      $('#braceletPreviewSection').show();
      $('#submitBtn').show();
      $('#quantityBtn').show();
      $('#resetProcessBtn').show()
      $('html,body')

      $('html,body').animate({scrollTop: $("#generateBraceletButton").offset().top}, 'fast');

      $('#MAIN_NAME', $svg2).css('font-size','0.6em');
      let div = document.getElementById('braceletContainerHidden');
      html2canvas(div).then(function (canvas) {
          $('#bracelet_image').val(canvas.toDataURL());
      })

    }
    
  }
  $('#nameField').keypress(function(e) {
      if(!(/^[A-Za-z0-9 ]*$/).test(e.key)){
        e.preventDefault();
      }
  });

  function setCharacter(character){
    var name_value = $('#nameField').val();
    $('#nameField').val(name_value + character);
  }

  function checkValidations(){
    var fname = document.getElementById("nameField");
    var radioSizes = document.getElementById("size1");
    var radioColors = document.getElementById("ans1");
    
    if(fname.reportValidity() && radioSizes.reportValidity() && radioColors.reportValidity()){
      if(getSelectedcolorsForm().length > 0){
        return true;
      }else{
        alert('Please select a color!');
        return false;
      }
      
    }
    return false;
  }

  function validateQuantity(){
    // validates quantity and special characters on quantity field
    var val = $('#quantityInput').val();
    if(val <= 0 || !(/^\d+$/.test(val))){
      alert("The quantity cannnot be less than 1 or contain special characters");
      event.preventDefault();
    }
  }

  function resetProcess(){
    $('#option1').show();
    $('#option2').show();
    $("#chooseType").text("Choose the type");
    $("#formSec").hide();
    $('#nameField').val('');
    $("#nameSection").hide();
    $("#colorsSection").hide();
    // $("#messageSection").hide();
    $('#generateBraceletButton').hide();
    $('#braceletPreviewSection').hide();
    $('#submitBtn').hide();
    $('#quantityBtn').hide();
    $('#resetProcessBtn').hide()
    // $('.formbold-radio-checkmark').addClass('remove-after');
    $('#size1').prop('checked', false);
    $('#size2').prop('checked', false);
    $('#size3').prop('checked', false);
    $('#ans1').prop('checked', false);
    $('#ans2').prop('checked', false);
    $('#ans3').prop('checked', false);
    // colors select menus
    $("#op1").hide();
    $("#op2").hide();
    $("#op3").hide();
    $("#op4").hide();
    $("#op5").hide();
    $("#op6").hide();
  }

  function hidePreviewSection(){
    $('#braceletPreviewSection').hide();
    $('#submitBtn').hide();
    $('#quantityBtn').hide();
    $('#resetProcessBtn').hide()

    $('#ans1').prop('checked', false);
    $('#ans2').prop('checked', false);
    $('#ans3').prop('checked', false);
    // colors select menus
    $("#op1").hide();
    $("#op2").hide();
    $("#op3").hide();
    $("#op4").hide();
    $("#op5").hide();
    $("#op6").hide();
  }

  function getSelectedcolors(){
    var selectMenus = ['op1','op2','op3','op4','op5','op6'];
    var selectedColors = [];
    for(let i=0; i<selectMenus.length; i++){

      let isVisible = $('#'+selectMenus[i]).css('display');
      if(isVisible == 'block'){
        let colorPicked = $('#'+selectMenus[i]).children('.option-container').children('.selected').children('.position').css('color');
        if(colorPicked !== ''){
          selectedColors.push(colorPicked)
        }
      }
    }
    return selectedColors;
  }

  function getSelectedcolorsForm(){
    var selectMenus = ['op1','op2','op3','op4','op5','op6'];
    var selectedColors = [];
    for(let i=0; i<selectMenus.length; i++){

      let isVisible = $('#'+selectMenus[i]).css('display');
      if(isVisible == 'block'){
        let colorPicked = $('#'+selectMenus[i]).children('.option-container').children('.selected').text();
        if(colorPicked !== ''){
          selectedColors.push(colorPicked)
        }
      }
    }
    return selectedColors;
  }

  // change event for size section
  $('#size1').change(function(){
    hidePreviewSection();
    $("#nameLabel").text("Name or phrase (Max. 10 characters)").css('font-weight', 'bold');
    $("#nameSection").show();
    $("#colorsSection").show();
    // $("#messageSection").show();
    $("#nameField").attr('maxlength','10');
    $('#generateBraceletButton').show();

    // load bracelet type depending on size
    if($("#typeField").val() === 'classic'){
      svgObjectID = "#_2D_BRACELET_SMALL";
      $('#nameField').val('');
      $("#braceletContainer").empty();
      $("#braceletContainer").load('/assets/svg/bracelet_classic_small.svg');
      
      svgObjectIdHidden = "#_2D_BRACELET_SMALL_HIDDEN";
      $("#braceletContainerHidden").empty();
      $("#braceletContainerHidden").load('/assets/svg/bracelet_classic_small_hidden.svg');
    }else{
      svgObjectID = "#_2D_BRACELET_UNICOLOR_SMALL";
      $('#nameField').val('');
      $("#braceletContainer").empty();
      $("#braceletContainer").load('assets/svg/bracelet_unicolor_small.svg');

      svgObjectIdHidden = "#_2D_BRACELET_UNICOLOR_SMALL_HIDDEN";
      $("#braceletContainerHidden").empty();
      $("#braceletContainerHidden").load('/assets/svg/bracelet_unicolor_small_hidden.svg');
    }
  });

  $('#size2').change(function(){
    hidePreviewSection();
    $("#nameLabel").text("Name or phrase (Max. 15 characters)").css('font-weight', 'bold');
    $("#nameSection").show();
    $("#colorsSection").show();
    // $("#messageSection").show();
    $("#nameField").attr('maxlength','15');
    $('#generateBraceletButton').show();
  
    // load bracelet type depending on size
    if($("#typeField").val() === 'classic'){
      svgObjectID = "#_2D_BRACELET_MEDIUM";
      $('#nameField').val('');
      $("#braceletContainer").empty();
      $("#braceletContainer").load('assets/svg/bracelet_classic_medium.svg');

      svgObjectIdHidden = "#_2D_BRACELET_MEDIUM_HIDDEN";
      $("#braceletContainerHidden").empty();
      $("#braceletContainerHidden").load('/assets/svg/bracelet_classic_medium_hidden.svg');

    }else{
      svgObjectID = "#_2D_BRACELET_UNICOLOR_MEDIUM";
      $('#nameField').val('');
      $("#braceletContainer").empty();
      $("#braceletContainer").load('assets/svg/bracelet_unicolor_medium.svg');

      svgObjectIdHidden = "#_2D_BRACELET_UNICOLOR_MEDIUM_HIDDEN";
      $("#braceletContainerHidden").empty();
      $("#braceletContainerHidden").load('/assets/svg/bracelet_unicolor_medium_hidden.svg');
    }
  });

  $('#size3').change(function(){
    hidePreviewSection();
    $("#nameLabel").text("Name or phrase (Max. 20 characters)").css('font-weight', 'bold');
    $("#nameSection").show();
    $("#colorsSection").show();
    // $("#messageSection").show();
    $("#nameField").attr('maxlength','20');
    $('#generateBraceletButton').show();    

    // load bracelet type depending on size
    if($("#typeField").val() === 'classic'){
      svgObjectID = "#_2D_BRACELET_LARGE";
      $('#nameField').val('');
      $("#braceletContainer").empty();
      $("#braceletContainer").load('assets/svg/bracelet_classic_large.svg');

      svgObjectIdHidden = "#_2D_BRACELET_LARGE_HIDDEN";
      $("#braceletContainerHidden").empty();
      $("#braceletContainerHidden").load('/assets/svg/bracelet_classic_large_hidden.svg');
    }else{
      svgObjectID = "#_2D_BRACELET_UNICOLOR_LARGE";
      $('#nameField').val('');
      $("#braceletContainer").empty();
      $("#braceletContainer").load('assets/svg/bracelet_unicolor_large.svg');

      svgObjectIdHidden = "#_2D_BRACELET_UNICOLOR_LARGE_HIDDEN";
      $("#braceletContainerHidden").empty();
      $("#braceletContainerHidden").load('/assets/svg/bracelet_unicolor_large_hidden.svg');
    }
  });


  // change event for color section
  $('#ans1').change(function(){
    $("#op1").show();
    $("#op2").hide();
    $("#op3").hide();
    $("#op4").hide();
    $("#op5").hide();
    $("#op6").hide();
  });

  $('#ans2').change(function(){
    $("#op1").hide();
    $("#op2").show();
    $("#op3").show();
    $("#op4").hide();
    $("#op5").hide();
    $("#op6").hide();
  });

  $('#ans3').change(function(){
    $("#op1").hide();
    $("#op2").hide();
    $("#op3").hide();
    $("#op4").show();
    $("#op5").show();
    $("#op6").show();
  });

</script>


<!-- Script for color select menus -->
<script>
  // script for quantity button
  jQuery(document).ready(($) => {
      $('.quantity').on('click', '.plus', function(e) {
          let $input = $(this).prev('input.qty');
          let val = parseInt($input.val());
          $input.val( val+1 ).change();
      });

      $('.quantity').on('click', '.minus', 
          function(e) {
          let $input = $(this).next('input.qty');
          var val = parseInt($input.val());
          if (val > 1) {
              $input.val( val-1 ).change();
          } 
      });
  });
    
  let selectContainer1 = document.querySelector(".op1");
  let select1 = document.querySelector(".select1");
  let options1 = document.querySelectorAll(".op1 .options1");
  let input1 = document.getElementById("input1");

  select1.onclick = () => {
      selectContainer1.classList.toggle("active");
  };

  options1.forEach((e) => {
      e.addEventListener("click", () => {
          input1.value = e.innerText;
          selectContainer1.classList.remove("active");
          options1.forEach((e) => {
              e.classList.remove("selected");
          });
          e.classList.add("selected");
      });
  });

  let selectContainer2 = document.querySelector(".op2");
  let select2 = document.querySelector(".select2");
  let options2 = document.querySelectorAll(".op2 .options2");
  let input2 = document.getElementById("input2");

  select2.onclick = () => {
      selectContainer2.classList.toggle("active");
  };

  options2.forEach((e) => {
      e.addEventListener("click", () => {
          input2.value = e.innerText;
          selectContainer2.classList.remove("active");
          options2.forEach((e) => {
              e.classList.remove("selected");
          });
          e.classList.add("selected");
      });
  });

  let selectContainer3 = document.querySelector(".op3");
  let select3 = document.querySelector(".select3");
  let options3 = document.querySelectorAll(".op3 .options3");
  let input3 = document.getElementById("input3");

  select3.onclick = () => {
      selectContainer3.classList.toggle("active");
  };

  options3.forEach((e) => {
      e.addEventListener("click", () => {
          input3.value = e.innerText;
          selectContainer3.classList.remove("active");
          options3.forEach((e) => {
              e.classList.remove("selected");
          });
          e.classList.add("selected");
      });
  });

  let selectContainer4 = document.querySelector(".op4");
  let select4 = document.querySelector(".select4");
  let options4 = document.querySelectorAll(".op4 .options4");
  let input4 = document.getElementById("input4");

  select4.onclick = () => {
      selectContainer4.classList.toggle("active");
  };

  options4.forEach((e) => {
      e.addEventListener("click", () => {
          input4.value = e.innerText;
          selectContainer4.classList.remove("active");
          options4.forEach((e) => {
              e.classList.remove("selected");
          });
          e.classList.add("selected");
      });
  });

  let selectContainer5 = document.querySelector(".op5");
  let select5 = document.querySelector(".select5");
  let options5 = document.querySelectorAll(".op5 .options5");
  let input5 = document.getElementById("input5");

  select5.onclick = () => {
      selectContainer5.classList.toggle("active");
  };

  options5.forEach((e) => {
      e.addEventListener("click", () => {
          input5.value = e.innerText;
          selectContainer5.classList.remove("active");
          options5.forEach((e) => {
              e.classList.remove("selected");
          });
          e.classList.add("selected");
      });
  });

  let selectContainer6 = document.querySelector(".op6");
  let select6 = document.querySelector(".select6");
  let options6 = document.querySelectorAll(".op6 .options6");
  let input6 = document.getElementById("input6");

  select6.onclick = () => {
      selectContainer6.classList.toggle("active");
  };

  options6.forEach((e) => {
      e.addEventListener("click", () => {
          input6.value = e.innerText;
          selectContainer6.classList.remove("active");
          options6.forEach((e) => {
              e.classList.remove("selected");
          });
          e.classList.add("selected");
      });
  });
</script>

@endsection