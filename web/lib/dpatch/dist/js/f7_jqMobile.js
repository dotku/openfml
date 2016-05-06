  function changePage(hash){
    parent.location.href = parent.location.href.replace(parent.window.location.hash,"") + hash;
  }