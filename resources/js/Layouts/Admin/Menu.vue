<template>


  <!-- ========== Left Sidebar Start ========== -->
  <!-- ========== Left Sidebar Start ========== -->
  <Header></Header>
  <div class="vertical-menu">

    <div data-simplebar class="h-100">

      <!--- Sidemenu -->
      <div id="sidebar-menu">
        <!-- Left Menu Start -->
        <ul class="metismenu list-unstyled" id="side-menu">

          <li>
            <Link href="/dashboard">
              <MenuIcon />
              <span data-key="t-dashboard">Dashboard</span>
            </Link>
          </li>
          <li>
            <Link href="/customer">
              <MenuIcon />
              <span data-key="t-dashboard">Customer</span>
            </Link>
          </li>


<!--              <li>-->
<!--                <a href="apps-chat.php">-->
<!--                  <span data-key="t-chat">Chat</span>-->
<!--                </a>-->
<!--              </li>-->

<!--              <li>-->
<!--                <a href="javascript: void(0);" class="has-arrow">-->
<!--                  <span data-key="t-email">Email</span>-->
<!--                </a>-->
<!--                <ul class="sub-menu" aria-expanded="false">-->
<!--                  <li><a href="apps-email-inbox.php" data-key="t-inbox">Inbox</a></li>-->
<!--                  <li><a href="apps-email-read.php" data-key="t-read-email">Read_Email</a></li>-->
<!--                </ul>-->
<!--              </li>-->


<!--            </ul>-->
<!--          </li>-->






        </ul>


      </div>
      <!-- Sidebar -->
    </div>
  </div>
  <!-- Left Sidebar End -->
</template>

<script>
import MenuIcon from 'vue-material-design-icons/Menu.vue';
import Header from './Header.vue';
import { Link } from '@inertiajs/inertia-vue3'
export default {
  components: {
    MenuIcon,
    Header,
    Link
  }
}
</script>