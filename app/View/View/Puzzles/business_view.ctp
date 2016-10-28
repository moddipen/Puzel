<style type="text/css">
    textarea.note-codable{ display: none;}
    .btn-toolbar{margin-left:0px !important; }
</style>

      
                
        <!-- Page content -->
        <div id="content" class="col-md-12">

          <!-- content main container -->
          <div class="main">
            <!-- cards -->
            <?php echo $this->element('business/header');?>

                        <!-- row -->
            <div class="row">


              <!-- col 8 -->
              <div class="col-lg-12 col-md-12">




                <!-- tile -->
                <!-- /tile -->



                <!-- tile -->
                <section class="tile color transparent-black padding10px">




                  <!-- tile header -->
                  
                  <!-- /tile header -->


                  <!-- tile body -->
                  <!-- <form role="form" class="custom-form" action ="pieces" method="post"> -->
                  <?php echo $this->form->create('Puzzle',array('action'=>'pieces','method'=>'post','class'=>"custom-form"));?>
                  <div class="tile-body">
                  <div class="row">
                    <div class="col-md-11">
                      
                        <div class="row">
                          <div class="col-md-6">
                              <div class="row minipadding">
                                  <div class="col-sm-8">
                                      <div class="form-group">
                                        <textarea class="form-control" style="height:87px; line-height:14pt;" id="script">
                                            &lt;script>
                                            <div id="paymentform_1"></div>
                                            &lt;/script>
                                            </textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                      <div class="form-group">
                                          <button type="button" class="btn btn-oranges fullwidth" onclick="copyToClipboard('#script')" id="copyScript">Copy Script</button>
                                        </div>
                                        <div class="form-group">
                                          <button type="button" class="btn btn-oranges fullwidth">Send to Developer</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                              <div class="row minipadding">
                                  <div class="col-sm-8">
                                      <div class="form-group">
                                        <?php $name = str_replace(' ','', $this->Session->read('IMAGECAPTURE.Puzzel.name'));?>
                                          <input type="text" class="form-control" value="http://puzel.stage.n-framescorp.com/<?php echo $name;?>" id="puzlename">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                      <div class="form-group">
                                          <button type="button" class="btn btn-oranges fullwidth" onclick="copyToClipboard('#puzlename')" id="copyButton">Copy</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row minipadding">
                                    <div class="col-sm-8">
                                      <div class="form-group">
                                          <input type="text" class="form-control" placeholder="Email Address">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                      <div class="form-group">
                                          <button type="button" class="btn btn-oranges fullwidth">Send</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                      
                    </div>
                  </div>
                  <input type ="hidden" value="<?php echo $this->Session->read('IMAGECAPTURE.Puzzel.base64');?>" name="data[Puzzle][image]">
                  <input type ="hidden" value="<?php echo $this->Session->read('IMAGECAPTURE.Puzzel.type');?>" name="data[Puzzle][type]">
                  <input type ="hidden" value="<?php echo $name;?>" name="data[Puzzle][name]">
                  <input type ="hidden" value="<?php echo $this->Session->read('IMAGECAPTURE.Puzzel.peice');?>" name="data[Puzzle][pieces]">
                  <input type ="hidden" value="<?php echo $this->Session->read('IMAGECAPTURE.Puzzel.transtion');?>" name="data[Puzzle][transtion]">
                  <input type ="hidden" value="<?php echo $this->Session->read('IMAGECAPTURE.Puzzel.source');?>" name="data[Puzzle][source]">
                  <div class="body" id="showimage">
                    <img src="<?php echo $this->Session->read('IMAGECAPTURE.Puzzel.base64');?>" class="img-responsive">
                  </div>
                  </div>
                  <!-- /tile body -->

          
                  <!-- tile footer -->
                  <div class="tile-footer text-center">
                  <div class="form-group">
                      <button type="submit" class="btn btn-oranges">Start Capturing</button>
                    </div>
                  </div>
                  <!-- /tile footer -->

                  <?php echo $this->form->end();?>

                </section>
                <!-- /tile -->


              </div>
              <!-- /col 8 -->



              <!-- col 4 -->
              
              <!-- /col 4 -->
              
              
            </div>
            <!-- /row -->


<script type="text/javascript">
    document.getElementById("copyButton").addEventListener("click", function()
     {
       copyToClipboard(document.getElementById("puzlename"));
    });
    document.getElementById("copyScript").addEventListener("click", function()
     {
       copyToClipboard(document.getElementById("script"));
    });

function copyToClipboard(elem) {
    // create hidden text element, if it doesn't already exist
    var targetId = "_hiddenCopyText_";
    var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
    var origSelectionStart, origSelectionEnd;
    if (isInput) {
        // can just use the original source element for the selection and copy
        target = elem;
        origSelectionStart = elem.selectionStart;
        origSelectionEnd = elem.selectionEnd;
    } else {
        // must use a temporary form element for the selection and copy
        target = document.getElementById(targetId);
        if (!target) {
            var target = document.createElement("textarea");
            target.style.position = "absolute";
            target.style.left = "-9999px";
            target.style.top = "0";
            target.id = targetId;
            document.body.appendChild(target);
        }
        target.textContent = elem.textContent;
    }
    // select the content
    var currentFocus = document.activeElement;
    target.focus();
    target.setSelectionRange(0, target.value.length);
    
    // copy the selection
    var succeed;
    try {
        succeed = document.execCommand("copy");
    } catch(e) {
        succeed = false;
    }
    // restore original focus
    if (currentFocus && typeof currentFocus.focus === "function") {
        currentFocus.focus();
    }
    
    if (isInput) {
        // restore prior selection
        elem.setSelectionRange(origSelectionStart, origSelectionEnd);
    } else {
        // clear temporary content
        target.textContent = "";
    }
    return succeed;
}
</script>