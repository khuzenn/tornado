<?php
$username = array(
    'name' => 'username',
    'id' => 'username',
    'class' => 'form-control',
    'value' => set_value('username'),
    'maxlength' => $this->config->item('username_max_length', 'tank_auth'),
    'placeholder' => 'Username',
    'autocomplete' => 'off'
);
$email = array(
    'name' => 'email',
    'id' => 'email',
    'class' => 'form-control',
    'value' => set_value('email'),
    'placeholder' => 'Email',
    'autocomplete' => 'off'
);
$password = array(
    'name' => 'password',
    'id' => 'password',
    'class' => 'form-control',
    'placeholder' => 'Katasandi',
    'value' => set_value('password'),
    'maxlength' => $this->config->item('password_max_length', 'tank_auth'),
    'size' => 30,
    'autocomplete' => 'off'
);
$confirm_password = array(
    'name' => 'confirm_password',
    'id' => 'confirm_password',
    'class' => 'form-control',
    'placeholder' => 'Konfirmasi Katasandi',
    'value' => set_value('confirm_password'),
    'maxlength' => $this->config->item('password_max_length', 'tank_auth'),
    'size' => 30,
    'autocomplete' => 'off'
);
$foto = array(
    'class' => 'form-control',
    'name' => 'foto',
    'id' => 'foto',
    'type' => 'file',
    'value' => set_value('foto'),
    'autocomplete' => 'off'
);
?>
<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
  <div class="layout-container">
    <!-- Layout container -->
    <div class="layout-page">
      <!-- Content wrapper -->
      <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
          <!-- Message -->
          <?php if (!empty($message)) { ?>
            <div class="col-xxl-3">
              <!--begin::Alert-->
              <div class="alert alert-success alert-dismissible position-fixed" style="top: 20px; right: 20px;" role="alert">
                <!--begin::Content-->
                <div class="d-flex flex-column pe-0 pe-sm-10">
                  <h4 class="fw-bold">Pesan</h4>
                  <span><?php echo $message; ?></span>
                </div>
                <!--end::Content-->
                <!--begin::Close-->
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <!--end::Close-->
              </div>
              <!--end::Alert-->
            </div>
          <?php } ?>
          
          <!-- Breadcrumb -->
          <h6 class="mb-2">
            <?php foreach ($breadcrumbs as $breadcrumb) { ?>
              <span class="<?php echo $breadcrumb['class']; ?>">
                <?php echo ($breadcrumb['active'] == TRUE) ? '<a href="' . $breadcrumb['href'] . '" class="pe-3 text-muted">' : NULL; ?>
                <?php echo $breadcrumb['text']; ?>
                <?php echo ($breadcrumb['active'] == TRUE) ? '</a>' : NULL; ?>
            <?php } ?>
            </h6>
          
          <div class="row pt-2">
            <!-- Basic Layout -->
            <div class="col-xxl">
              <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                  <h4 class="mb-0 fw-bold">Form Pendaftaran</h4>
                  <small class="text-muted float-end">Tambah Pengguna</small>
                </div>
                <div class="card-body">
                  <?php echo form_open($action, 'class="form-horizontal"'); ?>
                  
                  <?php if (isset($registration_fields)) { ?>
                    <?php foreach ($registration_fields as $val) { ?>
                      <?php list($name, $label, , $type) = $val; ?>
                      <?php $field = array('name' => $name, 'id' => $name, 'value' => set_value($name), 'placeholder' => $label, 'class' => 'form-control',); ?>
                      <?php if ($type == 'text') { ?>
                        <?php $field += array('size' => 30); ?>
                        <?php $attr = isset($val[4]) ? $val[4] : FALSE; ?>
                        <?php if ($attr) { ?>
                          <?php foreach ($attr as $k => $v) { ?>
                            <?php $field[$k] = $v; ?>
                          <?php } ?>
                        <?php } ?>
                        <div class="mb-3 row">
                          <label class="col-sm-3 col-form-label text-end"><?php echo $field['placeholder'] ?><span style="color:red;">*</span></label>
                          <div class="col-sm-9">
                            <?php echo form_input($field, array('class' => 'form-control', 'autocomplete' => 'off')); ?>
                          </div>
                          <span style="color: red;">
                            <?php echo form_error($field['name']); ?>
                            <?php echo isset($errors[$field['name']]) ? $errors[$field['name']] : ''; ?>
                          </span>
                          <span class="form-bar"></span>
                        </div>
                      <?php } ?>
                    <?php } ?>
                  <?php } ?>
                  
                  <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label text-end">Username<span style="color:red;">*</span></label>
                    <div class="col-sm-9">
                      <?php echo form_input($username); ?>
                      <span style="color: red;"><?php echo form_error($username['name']); ?><?php echo isset($errors[$username['name']]) ? $errors[$username['name']] : ''; ?></span>
                    </div>
                  </div>
                  
                  <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label text-end">Email<span style="color:red;">*</span></label>
                    <div class="col-sm-9">
                      <?php echo form_input($email); ?>
                      <span style="color: red;"><?php echo form_error($email['name']); ?><?php echo isset($errors[$email['name']]) ? $errors[$email['name']] : ''; ?></span>
                    </div>
                  </div>
                  
                  <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label text-end">Katasandi<span style="color:red;">*</span></label>
                    <div class="col-sm-9">
                      <?php echo form_password($password); ?>
                      <span style="color: red;"><?php echo form_error($password['name']); ?><?php echo isset($errors[$password['name']]) ? $errors[$password['name']] : ''; ?></span>
                    </div>
                  </div>
                  
                  <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label text-end">Konfirmasi Katasandi<span style="color:red;">*</span></label>
                    <div class="col-sm-9">
                      <?php echo form_password($confirm_password); ?>
                      <span style="color: red;"><?php echo form_error($confirm_password['name']); ?><?php echo isset($errors[$confirm_password['name']]) ? $errors[$confirm_password['name']] : ''; ?></span>
                    </div>
                  </div>
                  
                  <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label text-end">Jenis Kelamin<span style="color:red;">*</span> &nbsp</label>
                    <div class="col-sm-9">
                      <input type="radio" name="gender" class="form-check-input" value="P">&nbsp Pria &nbsp
                      <input type="radio" name="gender" class="form-check-input" value="W">&nbsp Wanita
                    </div>
                  </div>
                  
                  <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label text-end">Tanggal Lahir</label>
                    <div class="col-sm-9">
                      <input type="date" class="form-control" id="html5-date-input" name="tanggal_lahir" placeholder="Tanggal Lahir"/>
                    </div>
                  </div>
                  
                  <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label text-end">Alamat</label>
                    <div class="col-sm-9">
                      <textarea name="alamat" class="form-control" rows="5" placeholder="Alamat"></textarea>
                    </div>
                  </div>
                  
                  <div class="row justify-content-end">
                    <div class="col-sm-10">
                      <button type="submit" class="btn btn-primary">
                        <i class='bx bx-save'></i>&nbsp Simpan
                      </button>
                    </div>
                  </div>
                  
                  <?php echo form_close() ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- / Content -->
      </div>
    </div>
  </div>
</div>
