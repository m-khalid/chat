<template>
  <nav class="navbar navbar-expand-lg">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
  <ul class="navbar-nav mr-auto container-fluid">
    <li class="nav-item col mainli"> <router-link to='/'>view messages</router-link></li>
    <li class="nav-item col mainli"><router-link to='/search'>search</router-link></li>
    <li class="nav-item col mainli"><router-link to='/viewFriends'>View Frinds</router-link></li>
    <li class="col"></li>
    <li class="col"></li>
    <li class="col"></li>
    <li class="nav-item col mainli">
      <div class="navbarDropdown">
        <span>menu <font-awesome-icon :icon="['fas', 'chevron-circle-down']" /></span>

        <div class="navbarDropdownContent">
          <ul>
            <li><router-link to='/setting'>Setting</router-link></li>
            <li><router-link to='/about'>About</router-link></li>
            <li>Logout</li>
        </ul>
      </div>
      </div>
    </li>
  </ul>
  </div>
      </nav>
</template>

<script>
export default{
  name: 'mHeader'
}
</script>

<style scoped>

.navbar {
  background-color: #4160F5;
}

.navbar  .mainli {
  background-color: #4160F5;
  padding: 8px;
  text-decoration: none;
  border-radius: 5px;
}
.navbar li a{
  color: #ffff;
}
ul{
  list-style-type:none;
}

.navbar  li:hover{
  background-color: #2D4BDC;
cursor: pointer;
}

.navbarDropdownContent{
  display:none;
  position: absolute;
  background-color: #2D4BDC;
  color:#fff;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  padding: 12px 16px;
  z-index: 1;
  border-radius:5px;
}

.navbarDropdown:hover .navbarDropdownContent {
  display:block;
}
.navbarDropdown{
  display:block;
  color: #ffff;

}

.navbarDropdownContent li{
  padding:5px;
}
.micon{
  width:15px;
}
.router-link-active{
    background-color: #2D4BDC;
}
</style>
