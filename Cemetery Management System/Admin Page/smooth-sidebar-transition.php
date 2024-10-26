<style>
.sidebar {
  transition: width 0.3s ease, margin 0.3s ease;
}

.sidebar.toggled {
  width: 0;
  overflow: hidden;
}

/* Optional: Adjust the content area for smooth width transitions */
#content-wrapper, #main-container {
  transition: margin-left 0.3s ease, width 0.3s ease;
}

body.sidebar-toggled #content-wrapper, 
body.sidebar-toggled #main-container {
  margin-left: 0;
  width: 100%;
}

</style>