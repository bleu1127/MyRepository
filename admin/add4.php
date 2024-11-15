<?php
include('authentication.php');
include('includes/header.php');
?>




<head>
  <meta charset="utf-8" />
  <link rel="stylesheet" href="css/bootstrap-min.css">
  <link rel="stylesheet" href="app.css" type="text/css" />
</head>

<body>
  <div class="container-fluid px-0">


    <div class="row">

      <div class="col-md-12">
        <!-- <?php include('message.php'); ?> -->
        <div class="card">
          <div class="card-header">
            <h4>Register Student Assistants
              <a href="add3.php" class="btn btn-danger float-end">Back</a>
            </h4>
          </div>
          <!-- <form action="addcode.php" method="POST" enctype="multipart/form-data"> -->
          <!-- Hidden input to store base64 encoded fingerprint data -->
          <input type="hidden" id="fingerprintData" name="fingerprintData">
          
          <div id="Container">
            <nav class="navbar navbar-inverse">
              <div class="container-fluid">
                <div class="navbar-header">
                  <div class="navbar-brand" href="#" style="color: white;">Register Finger Print</div>
                </div>
                <ul class="nav navbar-nav">
                  <li id="Reader" class="active">
                    <a href="#" style="color: white;" onclick="toggle_visibility(['content-reader','content-capture']);setActive('Reader','Capture')">Reader</a>
                  </li>
                </ul>
                <ul class="nav navbar-nav">
                  <li id="Capture" class="">
                    <a href="#" style="color: white;" onclick="toggle_visibility(['content-capture','content-reader']);setActive('Capture','Reader')">Capture</a>
                  </li>
                </ul>
              </div>
            </nav>
          
            <div id="Scores">
              <h5>Scan Quality : <input type="text" id="qualityInputBox" size="20" style="background-color:#DCDCDC;text-align:center;"></h5>
            </div>

            <div id="content-capture" style="display : none;">
              <div id="status"></div>
              <div id="imagediv"></div>
              <div id="contentButtons">
                <table width=70% align="center">
                  <tr>
                    <td>
                      <input type="button" class="btn btn-primary" id="clearButton" value="Clear" onclick="Javascript:onClear()">
                    </td>
                    <td data-toggle="tooltip" title="Will work with the .png format.">
                      <input type="button" class="btn btn-primary" name="save" id="save" value="Save">
                    </td>
                    <td>
                      <input type="button" class="btn btn-primary" id="start" value="Start" onclick="Javascript:onStart()">
                    </td>
                    <td>
                      <input type="button" class="btn btn-primary" id="stop" value="Stop" onclick="Javascript:onStop()">
                    </td>
                    <td>
                    <td><button type="submit" name="add_btn" class="btn btn-primary">Register</button></td>
                    </td>
                </table>
                
              </div>

              <div id="imageGallery"></div>
              <div id="deviceInfo"></div>

              <div id="saveAndFormats">
                <form name="myForm" style="border : solid grey;padding:5px;">
                  <b>Acquire Formats :</b><br>
                  <table>
                    <tr data-toggle="tooltip" title="Will save data to a .png file.">
                      <td><input type="checkbox" name="PngImage" checked="true" value="4" onclick="checkOnly(this)"> PNG</td>
                    </tr>
                  </table>
                </form>
                <br>
                <input type="button" class="btn btn-primary" id="saveImagePng" value="Export" onclick="Javascript:onImageDownload()">
              </div>
            </div>

            <div id="content-reader">
              <h4>Select Reader :</h4>
              <select class="form-control" id="readersDropDown" onchange="selectChangeEvent()"></select>
              <div id="readerDivButtons">
                <table width=70% align="center">
                  <tr>
                    <td><input type="button" class="btn btn-primary" id="refreshList" value="Refresh List" onclick="Javascript:readersDropDownPopulate(false)"></td>
                    <td><input type="button" class="btn btn-primary" id="capabilities" value="Capabilities" data-toggle="modal" data-target="#myModal" onclick="Javascript:populatePopUpModal()"></td>
                  </tr>
                </table>
              </div>

              <!-- Modal - Pop Up window content-->
              <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog">
                  <div class="modal-content" id="modalContent">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Reader Information</h4>
                    </div>
                    <div class="modal-body" id="ReaderInformationFromDropDown"></div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script src="lib/jquery.min.js"></script>
  <script src="lib/bootstrap.min.js"></script>
  <script src="scripts/es6-shim.js"></script>
  <script src="scripts/websdk.client.bundle.min.js"></script>
  <script src="scripts/fingerprint.sdk.min.js"></script>
  <script src="app.js"></script>
</body>




<?php
include('includes/footer.php');
include('includes/scripts.php');
?>