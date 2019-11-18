
        <div class="top_nav footer_fixed">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>
              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <?php if ($this->session->userdata('id_users') == '') { ?>
                       <!-- <img src="<?php echo base_url('uploads/'.$this->session->userdata('foto')) ?>" alt=""> -->
                        <img src="<?php echo base_url('images/user.png'); ?>" alt="...">
                      <?php } else {
                        $id_users = $this->session->userdata('id_users');
                        $cek_data = $this->db->get_where('app_users',"id_users='$id_users'")->row();
                        $foto = $this->M_users->cek_filename($cek_data->foto);?>
                        <img src="<?php echo base_url($foto); ?>" alt="...">
                    <?php } ?>

                    <?php echo strtoupper($this->session->userdata('username')); ?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="<?php echo base_url(); ?>Profil"><i class="fa fa-user"></i> Profile</a></li>
                    <!-- <li>
                      <a id="setting" href="javascript:void(0);"><i class="fa fa-cog"></i> Setting
                        <span class="badge bg-red pull-right">50%</span>

                      </a>
                    </li>
                    <li><a href="javascript:;"><i class="fa fa-question"></i> Help</a></li> -->

                     <li>
                      <a id="keluar" href="javascript:void(0)"><i class="fa fa-sign-out pull-left"></i>Logout</a>
                       <!-- <a onclick="return confirm ('Yakin Data Ingin Keluar.?');" href="<?php echo base_url('login/logout') ?>"><i class="fa fa-sign-out pull-left"></i>Logout</a> -->
                    </li>

                  </ul>
                </li>

                <li role="presentation" class="dropdown">
                  <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-envelope-o"></i>
                    <span class="badge bg-green"></span>
                  </a>
                  <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">

                      <?php for ($i=0; $i <= 4; $i++) { ?>
                       <li>
                      <a>
                        <span class="image"><img src="<?php echo base_url() ?>images/admin.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>

                     <?php }

                      ?>


                    <li>
                      <div class="text-center">
                        <a>
                          <strong>See All Alerts</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
