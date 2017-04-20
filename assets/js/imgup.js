var picArray = [];
function previewImage(file) {
  var MAXWIDTH = 350;
  var MAXHEIGHT = 249;
  //var div = document.getElementById('preview');
  var div = findPreview(file.parentNode);
  // console.log(file.value);
  if (file.files && file.files[0]) {
    //限制图片尺寸
    if(file.files[0].size > 819200) {
      alert('图片尺寸不能超过800kb');
      return false;
    }
    //限制图片格式
    var extension = /\.(gif|jpg|jpeg|png|svg)$/i;
    if(!extension.test(file.files[0].name)) {
      alert('图片格式不符！');
      return false;
    }

    picArray[0]=file.files[0];
    div.innerHTML = '<img id=imghead>';
    //var img = document.getElementById('imghead');
    var img = div.lastChild;
    img.onload = function() {
      var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
      img.width = rect.width;
      img.height = rect.height;
    }
    var reader = new FileReader();
    reader.onload = function(evt) {
      img.src = evt.target.result;
    }
    reader.readAsDataURL(file.files[0]);
  } else //鍏煎IE
  {
    //alert("123");
    var sFilter = 'filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src="';
    file.select();
    var src = document.selection.createRange().text;
    div.innerHTML = '<img id=imghead>';
    //var img = document.getElementById('imghead');
    var img = div.lastChild;
    img.filters.item('DXImageTransform.Microsoft.AlphaImageLoader').src = src;
    var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
    status = ('rect:' + rect.top + ',' + rect.left + ',' + rect.width + ',' + rect.height);
    div.innerHTML = "<div id=divhead style='width:" + rect.width + "px;height:" + rect.height + "px;margin-top:" + rect.top + "px;" + sFilter + src + "\"'></div>";
  }
}

function clacImgZoomParam(maxWidth, maxHeight, width, height) {
  var param = {
    top: 0,
    left: 0,
    width: width,
    height: height
  };
  if (width > maxWidth || height > maxHeight) {
    rateWidth = width / maxWidth;
    rateHeight = height / maxHeight;

    if (rateWidth > rateHeight) {
      param.width = maxWidth;
      param.height = Math.round(height / rateWidth);
    } else {
      param.width = Math.round(width / rateHeight);
      param.height = maxHeight;
    }
  }

  param.left = Math.round((maxWidth - param.width) / 2);
  param.top = Math.round((maxHeight - param.height) / 2);
  return param;
}

function findPreview(parent) {
  var childs = parent.childNodes;
  for (var i = 0; i < childs.length; i++) {
    if (childs[i].id == "preview")
      return childs[i];
  }

  return div = document.getElementById('preview');
}
