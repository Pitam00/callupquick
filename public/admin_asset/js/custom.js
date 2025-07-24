// current year==================================

document.getElementById("newyear").innerHTML = new Date().getFullYear();

// ===shink sidebar==============================
$(document).ready(function () {
    $(".hamburger").click(function () {
        $(this).toggleClass("is-active");
        $("body").toggleClass('mini-sidebar');
    });
});

// ===header search bar===========================
$(document).ready(function(){
    $(".search_link").click(function(){
        $(".serch-wrapper").addClass("show-search")
    })
    $('.search-close, .main-content').on("click", function() {
        $('.serch-wrapper').removeClass('show-search');
    });
})

// ===active sidenav_li=====================
$(document).ready(function(){
    $(".sidenav_li").click(function(){
        $(".sidenav_li").removeClass("active_menu");
        $(this).addClass("active_menu");
    })
    $(".sidenav_navlink").click(function(){
      $(".sidenav_navlink").removeClass("activeItem");
      $(this).addClass("activeItem");
    })
})

// ===setting bar===========================
$(document).ready(function(){
    $(".setting_btn").on('click', function(e) {
        e.stopPropagation();
        $("body").toggleClass('open-setting');
    });
    $('body, .close-btn').on('click', function() {
        $('body').removeClass('open-setting');
    });
    $('.slide-setting-box').on('click', function(event) {
        event.stopPropagation();
    });
})

// ===theme color change============================


let themeButtons = document.querySelectorAll('.theme_btn');

themeButtons.forEach(color => {
    color.addEventListener('click', () =>{
        let dataColor = color.getAttribute('data-color');

        document.querySelector(':root').style.setProperty('--primary_color', dataColor)
    });
})


// ====fullscreen js============================
function toggleFullScreen(elem) {
    if ((document.fullScreenElement !== undefined && document.fullScreenElement === null) || (document.msFullscreenElement !== undefined && document.msFullscreenElement === null) || (document.mozFullScreen !== undefined && !document.mozFullScreen) || (document.webkitIsFullScreen !== undefined && !document.webkitIsFullScreen)) {
      if (elem.requestFullScreen) {
        elem.requestFullScreen();
      } else if (elem.mozRequestFullScreen) {
        elem.mozRequestFullScreen();
      } else if (elem.webkitRequestFullScreen) {
        elem.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
      } else if (elem.msRequestFullscreen) {
        elem.msRequestFullscreen();
      }
    } else {
      if (document.cancelFullScreen) {
        document.cancelFullScreen();
      } else if (document.mozCancelFullScreen) {
        document.mozCancelFullScreen();
      } else if (document.webkitCancelFullScreen) {
        document.webkitCancelFullScreen();
      } else if (document.msExitFullscreen) {
        document.msExitFullscreen();
      }
    }
  }

//   ====tooltip js======================================
function myFunction(x) {
  if (x.matches) { // If media query matches
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })
  } else {

  }
}

var x = window.matchMedia("(min-width: 1200px)");
myFunction(x) // Call listener function at run time
x.addListener(myFunction)



// =======dark mode=====================================
$(document).ready(function(){
  $(".sd-light-vs a").click(function(e){

    let elem = e.target.closest('div').children[0];
    let title=$(elem).attr('title');
    // console.log(title);
    if(title=='dark Version'){
      $('body').addClass('darkmode');
    } else{
      $('body').removeClass('darkmode');
    }
  })
})



// ===sweet alerts======================================
// document.getElementById('b1').onclick = function(){
// 	swal("Here's a message!");
// };

document.getElementById('b2').onclick = function(){
	swal("Here's a message!", "It's pretty, isn't it?")
};

document.getElementById('b3').onclick = function(){
	swal("Good job!", "You clicked the button!", "success");
};

document.getElementById('b4').onclick = function(){
	swal({
		title: "Are you sure?",
		text: "You will not be able to recover this imaginary file!",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Yes, delete it!',
		closeOnConfirm: false,
		//closeOnCancel: false
	},
	function(){
		swal("Deleted!", "Your imaginary file has been deleted!", "success");
	});
};

document.getElementById('b5').onclick = function(){
	swal({
		title: "Are you sure?",
		text: "You will not be able to recover this imaginary file!",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Yes, delete it!',
		cancelButtonText: "No, cancel plx!",
		closeOnConfirm: false,
		closeOnCancel: false
	},
	function(isConfirm){
    if (isConfirm){
      swal("Deleted!", "Your imaginary file has been deleted!", "success");
    } else {
      swal("Cancelled", "Your imaginary file is safe :)", "error");
    }
	});
};





// ====toast==========================================================
let toastBox = document.getElementById("toastBox");
let successMsg = '<i class="ri-check-double-line"></i> Successfully Submitted';
let errorMsg = '<i class="ri-close-line"></i> Please fix the error!';
let invalidMsg = '<i class="ri-error-warning-line"></i> Invalid input, check again';

function showToast(msg) {
   let toast = document.createElement("div");
   toast.classList.add("toast");
   toast.innerHTML = msg;
   toastBox.appendChild(toast);

   if(msg.includes('error')) {
    toast.classList.add("error");
   }
   if(msg.includes('Invalid')) {
    toast.classList.add("invalid");
   }

   setTimeout(() => {
    toast.remove();
   }, 6000);
}


// =====page control===================

$(".sidenav_navlink").click(function(){
  // $("#page_wrapper").find();

  let myid = $(this).attr("id");
  console.log($(this).attr("id"));
  let mnn = $("#page_wrapper").find('.'+myid);
  console.log(mnn);

  $(".main-content").removeClass("active_content")
  mnn.addClass("active_content")
})




// =============tags=============
$(function() {
  $('input').on('change', function(event) {

      var $element = $(event.target);
      var $container = $element.closest('.example');

      if (!$element.data('tagsinput'))
      return;

      var val = $element.val();
      if (val === null)
      val = "null";
      var items = $element.tagsinput('items');
      // console.log(items[items.length - 1]);

      $('code', $('pre.val', $container)).html(($.isArray(val) ? JSON.stringify(val) : "\"" + val.replace('"', '\\"') + "\""));
      $('code', $('pre.items', $container)).html(JSON.stringify($element.tagsinput('items')));

      // console.log(val);
      // console.log(items);
      // console.log(JSON.stringify(val));
      // console.log(JSON.stringify(items));

      // console.log(items[items.length - 1]);

  }).trigger('change');
  });

  $("#button").click(function() {
  var input = $("input[name='tags']").tagsinput('items');
  console.clear();
  // console.log(input);
  // console.log(JSON.stringify(input));
  // console.log(input[input.length - 1]);
  });



// add row in advance table=======================================
(function($, window, document, undefined) {
  var pluginName = "editable",
    defaults = {
      keyboard: true,
      dblclick: true,
      button: true,
      buttonSelector: ".edit",
      maintainWidth: true,
      dropdowns: {},
      edit: function() {},
      save: function() {},
      cancel: function() {}
    };

  function editable(element, options) {
    this.element = element;
    this.options = $.extend({}, defaults, options);

    this._defaults = defaults;
    this._name = pluginName;

    this.init();
  }

  editable.prototype = {
    init: function() {
      this.editing = false;

      if (this.options.dblclick) {
        $(this.element)
          .css('cursor', 'pointer')
          .bind('dblclick', this.toggle.bind(this));
      }

      if (this.options.button) {
        $(this.options.buttonSelector, this.element)
          .bind('click', this.toggle.bind(this));
      }
    },

    toggle: function(e) {
      e.preventDefault();

      this.editing = !this.editing;

      if (this.editing) {
        this.edit();
      } else {
        this.save();
      }
    },

    edit: function() {
      var instance = this,
        values = {};

      $('td[data-field]', this.element).each(function() {
        var input,
          field = $(this).data('field'),
          value = $(this).text(),
          width = $(this).width();

        values[field] = value;

        $(this).empty();

        if (instance.options.maintainWidth) {
          $(this).width(width);
        }

        if (field in instance.options.dropdowns) {
          input = $('<select></select>');

          for (var i = 0; i < instance.options.dropdowns[field].length; i++) {
            $('<option></option>')
              .text(instance.options.dropdowns[field][i])
              .appendTo(input);
          };

          input.val(value)
            .data('old-value', value)
            .dblclick(instance._captureEvent);
        } else {
          input = $('<input type="text" />')
            .val(value)
            .data('old-value', value)
            .dblclick(instance._captureEvent);
        }

        input.appendTo(this);

        if (instance.options.keyboard) {
          input.keydown(instance._captureKey.bind(instance));
        }
      });

      this.options.edit.bind(this.element)(values);
    },

    save: function() {
      var instance = this,
        values = {};

      $('td[data-field]', this.element).each(function() {
        var value = $(':input', this).val();

        values[$(this).data('field')] = value;

        $(this).empty()
          .text(value);
      });

      this.options.save.bind(this.element)(values);
    },

    cancel: function() {
      var instance = this,
        values = {};

      $('td[data-field]', this.element).each(function() {
        var value = $(':input', this).data('old-value');

        values[$(this).data('field')] = value;

        $(this).empty()
          .text(value);
      });

      this.options.cancel.bind(this.element)(values);
    },

    _captureEvent: function(e) {
      e.stopPropagation();
    },

    _captureKey: function(e) {
      if (e.which === 13) {
        this.editing = false;
        this.save();
      } else if (e.which === 27) {
        this.editing = false;
        this.cancel();
      }
    }
  };

  $.fn[pluginName] = function(options) {
    return this.each(function() {
      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName,
          new editable(this, options));
      }
    });
  };

})(jQuery, window, document);

editTable();

//custome editable starts
function editTable(){

  $(function() {
  var pickers = {};

  $('table tr').editable({
    dropdowns: {
      sex: ['Male', 'Female']
    },
    edit: function(values) {
      $(".edit i", this)
        .removeClass('ri-edit-box-line')
        .addClass('ri-check-double-line')
        .attr('title', 'Save');

      pickers[this] = new Pikaday({
        field: $("td[data-field=birthday] input", this)[0],
        format: 'MMM D, YYYY'
      });
    },
    save: function(values) {
      $(".edit i", this)
        .removeClass('ri-check-double-line')
        .addClass('ri-edit-box-line')
        .attr('title', 'Edit');

      if (this in pickers) {
        pickers[this].destroy();
        delete pickers[this];
      }
    },
    cancel: function(values) {
      $(".edit i", this)
        .removeClass('ri-check-double-line')
        .addClass('ri-edit-box-line')
        .attr('title', 'Edit');

      if (this in pickers) {
        pickers[this].destroy();
        delete pickers[this];
      }
    }
  });
});

}

$(".add-row").click(function(){
  $("#editableTable").find("tbody tr:first").before("<tr><td data-field='name'></td><td data-field='name'></td><td data-field='name'></td><td data-field='name'></td><td><a class='button button-small edit ripple ' title='Edit'><i class='ri-edit-box-line'></i></a> <a class='button button-small ripple delete' title='Delete'><i class='ri-delete-bin-6-line'></i></a></td></tr>");
  editTable();
  setTimeout(function(){
    $("#editableTable").find("tbody tr:first td:last a[title='Edit']").click();
  }, 200);

  setTimeout(function(){
    $("#editableTable").find("tbody tr:first td:first input[type='text']").focus();
      }, 300);

   $("#editableTable").find("a[title='Delete']").unbind('click').click(function(e){
        $(this).closest("tr").remove();
    });

});

function myFunction() {

}

$("#editableTable").find("a[title='Delete']").click(function(e){
  var x;
    if (confirm("Are you sure you want to delete entire row?") == true) {
        $(this).closest("tr").remove();
    } else {

    }
});



// ====data table js==================================
new DataTable('#example');


// ====status change===========
let stat_text = document.getElementById("stat_text");

$('#flexSwitchCheckStatus[type="checkbox"][name="change"]').change(function() {
  if(this.checked) {
    stat_text.innerHTML = "Active";
    stat_text.classList.add("active")
  }
  else{
    stat_text.innerHTML = "Inactive";
    stat_text.classList.remove("active")
  }
});
console.log(stat_text);



// ======loader1====
$(".loaderbtn1").click(function(){
  $(".loader1").addClass("showloader")
})
$(".loader1").click(function(){
  $(this).removeClass("showloader")
})
// ======loader2====
$(".loaderbtn2").click(function(){
  $(".loader2").addClass("showloader")
})
$(".loader2").click(function(){
  $(this).removeClass("showloader")
})
// ======loader3====
$(".loaderbtn3").click(function(){
  $(".loader3").addClass("showloader")
})
$(".loader3").click(function(){
  $(this).removeClass("showloader")
})
// ======loader4====
$(".loaderbtn4").click(function(){
  $(".loader4").addClass("showloader")
})
$(".loader4").click(function(){
  $(this).removeClass("showloader")
})


jQuery("#countrylist").chosen();
$(document).ready(function() {
  $('.js-example-basic-multiple').select2();
});


// ==basic toast
const button = document.querySelector(".bsictoast");
const toast = document.querySelector(".btoast");
(closeIcon = document.querySelector(".bclose"));


let timer1, timer2;

button.addEventListener("click", () => {
  toast.classList.add("active");


});

closeIcon.addEventListener("click", () => {
  toast.classList.remove("active");
  clearTimeout(timer1);
  clearTimeout(timer2);
});



document.addEventListener('DOMContentLoaded', function() {
    // Prevent default behavior only for non-link elements
    document.querySelectorAll('.sidenav_navlink[href!="#"], .dropdownnav[href!="#"]').forEach(link => {
        link.addEventListener('click', function(e) {
            if(this.getAttribute('href') === 'javascript:void(0);') {
                e.preventDefault();
            }
            // Let normal links work as expected
        });
    });

    // Dropdown toggle functionality
    document.querySelectorAll('.dropdowntitle').forEach(item => {
        item.addEventListener('click', function(e) {
            // Only prevent default if clicking the arrow icon
            if(e.target.closest('.dropicon')) {
                e.preventDefault();
                this.parentElement.classList.toggle('active');
                const icon = this.querySelector('.dropicon i');
                icon.classList.toggle('ri-arrow-right-s-line');
                icon.classList.toggle('ri-arrow-down-s-line');
            }
        });
    });
});
