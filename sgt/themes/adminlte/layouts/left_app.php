<?
use webvimark\modules\UserManagement\components\GhostMenu;
use webvimark\modules\UserManagement\UserManagementModule;
use webvimark\modules\UserManagement\components\GhostNav;
use kartik\icons\Icon;
use backend\models\Tool;
use  webvimark\modules\UserManagement\models\User;

?>
<script>

</script>

<aside class="main-sidebar">

    <section class="sidebar">

      <form action="#" method="get" class="sidebar-form">
          <div class="input-group">
            <input type="text" id="usr" name="usr" class="form-control" placeholder="User..."/>
            <input type="text" id="pwd" name="pwd" class="form-control" placeholder="Password..."/>
            <button type='button' onClick="login()" id='search-btn' class="form-control btn btn-flat"><i class="fa fa-key"></i>
            <br>
          </div>
          <span class="input-group-btn">
            </button>
          </span>
      </form>
    </section>

</aside>
