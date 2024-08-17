<!-- Modal -->
<div class="modal modal-center fade">
  <div class="modal-dialog" style="width: 500px; max-width:90vw;">
    <div class="modal-content">
      <div class="modal-body" style="max-height:95vh; overflow-y: auto;">
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
        <div class="px-15 py-10">
          <h4 class="header-title text-center"><strong>Δημιουργία λογαρισμού παρόχου:</strong></h4>
          <hr class="border-primary w-200px"><br />
          <!--
          |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
          | Form validation
          |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
          !-->
          <form data-provide="wizard" novalidate="true" method="post">
            <ul class="nav nav-process nav-process-circle">
              <li class="nav-item">
                <span class="nav-title">Στοιχεία</span>
                <a class="nav-link" data-toggle="tab" href="#wizard-validate-1"></a>
              </li>

              <li class="nav-item">
                <span class="nav-title">Διεύθυνση</span>
                <a class="nav-link" data-toggle="tab" href="#wizard-validate-2"></a>
              </li>

              <li class="nav-item">
                <span class="nav-title">Τράπεζα</span>
                <a class="nav-link" data-toggle="tab" href="#wizard-validate-3"></a>
              </li>
            </ul>


            <div class="tab-content">
              <div class="tab-pane fade active show" id="wizard-validate-1" >
                <p class="text-center text-muted">
                  <i class="fa fa-quote-left fa-2x fa-pull-left"></i>
                  <i>Δώστε μας μερικά στοιχεία.</i>
                </p>
                <hr class="w-200px">
                <div class="row">
                  <div class="form-group col-6">
                    <label>Όνομα</label>
                    <input class="form-control" type="text">
                  </div>

                  <div class="form-group col-6">
                    <label>Επώνυμο</label>
                    <input class="form-control" type="text">
                  </div>

                  <div class="form-group col-12">
                    <label>Username</label>
                    <input class="form-control" type="text" data-minlength="6" name="username" required>
                    <div class="invalid-feedback"></div>
                  </div>

                  <div class="form-group col-12">
                    <label>Email</label>
                    <input class="form-control" type="email" required>
                    <div class="invalid-feedback"></div>
                  </div>

                  <div class="form-group col-12">
                    <label>Κωδικός</label>
                    <input class="form-control" id="input-pass" type="password" data-minlength="8" data-provide="pwstrength" required>
                    <div class="invalid-feedback"></div>
                  </div>

                  <div class="form-group col-12">
                    <label>Επιβεβαίωση κωδικού</label>
                    <input class="form-control" id="input-pass-confirm" data-minlength="8" data-match="#input-pass" type="password" required>
                    <div class="invalid-feedback"></div>
                  </div>
                </div>
              </div>



              <div class="tab-pane fade" id="wizard-validate-2" data-provide="validation">
                <p class="text-center text-muted">
                  <i>Κείμενο...</i>
                </p>
                <hr class="w-200px">
                <div class="form-group">
                  <label for="inputAddress" class="col-form-label">Διεύθυνση γραμμή 1</label>
                  <input type="text" class="form-control" id="inputAddress">
                </div>

                <div class="form-group">
                  <label for="inputAddress2" class="col-form-label">Διεύθυνση γραμμή 2</label>
                  <input type="text" class="form-control" id="inputAddress2">
                </div>

                <div class="form-group">
                  <label for="inputCity" class="col-form-label">Πόλη</label>
                  <input type="text" class="form-control" id="inputCity">
                </div>

                <div class="form-group">
                  <label for="inputState" class="col-form-label">Νομός</label>
                  <input type="text" class="form-control" id="inputState">
                </div>

                <div class="form-group">
                  <label for="inputZip" class="col-form-label">Ταχ. Κώδικας</label>
                  <input type="text" class="form-control" id="inputZip">
                </div>
              </div>



              <div class="tab-pane fade" id="wizard-validate-3" data-provide="validation">
                <p class="text-center text-muted">
                  <i>Κείμενο...</i>
                </p>
                <hr class="w-200px">
                <div class="row">
                  <div class="form-group col-12">
                    <label>Αριθμός ΙΒΑΝ:</label>
                    <input class="form-control" type="text">
                  </div>
                  <div class="form-group col-12">
                    <label>Όνομα τράπεζας:</label>
                    <input class="form-control" type="text">
                  </div>
                  <div class="form-group col-12">
                    <label>Όνομα Δικαιούχου:</label>
                    <input class="form-control" type="text">
                  </div>
                </div>

                <div class="form-group">
                  <label class="custom-control custom-checkbox mr-3">
                    <input type="checkbox" class="custom-control-input">
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description">Συμφωνώ με τους όρους.</span>
                  </label>
                </div>

              </div>
            </div>

            <hr>

            <div class="flexbox">
              <button class="btn btn-secondary" data-wizard="prev" type="button">Πίσω</button>
              <button class="btn btn-secondary" data-wizard="next" type="button">Επόμενο</button>
              <button class="btn btn-primary d-none" data-wizard="finish" type="submit">Επιβεβαίωση</button>
            </div>
          </form>


        </div>
      </div>
    </div>
  </div>
</div>
