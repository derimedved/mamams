(function ($, settings) {
  "use strict";


  /**
   * Checkout
   *
   * @param options
   */
  const Profile = function (options) {
    const $formProfileInfo = $(".ajax_profile_form_info"),
      $sidebarProfile = $(".profile-column"),
      $btnAddChil = $(".btn_add_child"),
      $btnRemoveChil = $(".btn_remove_child"),
      $btnAddTheme = $(".btn_add_theme"),
      $fildsPercentage = $('input[name="first_name"],input[name="last_name"],input[name="age"],input[name="phone"],input[name="dob"],input[name="waiting"]');

      var childDropzoneArr = [];
    function scrollTo($class) {
      $([document.documentElement, document.body]).animate(
        {
          scrollTop: $($class).offset().top,
        },
        700
      );
    }

    function setCookie(name, value, days) {
      var expires = "";
      if (days) {
        var date = new Date();
        date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
        expires = "; expires=" + date.toUTCString();
      }
      document.cookie = name + "=" + (value || "") + expires + "; path=/";
    }
    function getCookie(name) {
      var nameEQ = name + "=";
      var ca = document.cookie.split(";");
      for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == " ") c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
      }
      return null;
    }

    function updPercentageDelayLoop(animationType, textWrap, container, percentage, newPercentage) {
      setTimeout(function () {
        if (animationType == "up") {
          percentage++;
          if (percentage < newPercentage) {
            textWrap.text(percentage + "%");
            container.attr("class", "c100 p" + percentage + " small");
            updPercentageDelayLoop(animationType, textWrap, container, percentage, newPercentage);
          }
        }
        if (animationType == "down") {
          percentage--;
          if (percentage > newPercentage) {
            textWrap.text(percentage + "%");
            container.attr("class", "c100 p" + percentage + " small");
            updPercentageDelayLoop(animationType, textWrap, container, percentage, newPercentage);
          }
        }
      }, 50);
    }

    function updPercentage() {
      var container = $("div[data-percentage]"),
        percentage = container.data("percentage") || 0,
        textWrap = container.find("span"),
        totalFields = 0,
        filledFields = 0;

      if (container && percentage && textWrap) {
        var fields = $fildsPercentage;
        totalFields += fields.length + 2;
        fields.each(function () {
          if ($(this).val() != "") ++filledFields;
        });
        if ($(".item:not(.children-item-clone)").length) ++filledFields;
        if ($(".themes-item:not(.themes-item-clone)").length) ++filledFields;
        var newPercentage = Math.round((filledFields / totalFields) * 100);
        if (newPercentage != percentage) {
          var animationType = newPercentage > percentage ? "up" : "down";
          updPercentageDelayLoop(animationType, textWrap, container, percentage, newPercentage);
          container.data("percentage", newPercentage);
          percentage = newPercentage;
        }
      }
    }

    function updName() {
      var first_name = $('input[name="first_name"]').val() || "",
        last_name = $('input[name="last_name"]').val() || "",
        age = $('input[name="age"]').val() || "",
        newName = "";

      newName += first_name + " " + last_name;
      newName = newName.trim();
      newName += age && newName != "" ? ", " + age : age;
      $(".profile-image-wrap p").text(newName);
    }

    function updProfileChildName() {
      if($('.profile-children').length) {
        var container = $('.profile-children-list'),
            $childItems = container.find(".item:not(.children-item-clone)");
        if($childItems) {
          var html = '<p>'+$('.profile-children').data('child_title')+'</p>';
              html += '<ul>';
        
          $childItems.each(function (index,el) {
            var name = $(el).find('.child_name').val();
            var age = $(el).find('.child_age').val();
            html += '<li>';
            html += name || '';
            if(name&&age)
            html += ', ';
            html += age || '';
            html += '</li>';
          });
          html += '</ul>';
          $('.profile-children').html(html);
        }
      }
    }

    function updChildName() {
      var item = $(this).closest(".item"),
        name = item.find(".child_name").val() || "",
        age = item.find(".child_age").val() || "",
        newName = "";
      newName += name;
      newName = newName.trim();
      newName += age && newName != "" ? ", " + age : age;
      item.find("figcaption").text(newName);
      updProfileChildName();
    }

    const mamamsAjax = function (submitData, onSuccess, container = null, action = "GET") {
      $.ajax({
        type: action,
        url: window.global.url,
        data: submitData,
        dataType: "json",
        beforeSend: function (response) {
          // Add loader
          if (container) container.addClass("loading");
        },
        complete: function (response) {
          if (container) container.removeClass("loading");
        },
        success: onSuccess,
      });
    };

    const addNotice = function (e) {
      e.preventDefault();

      var datas = $(this).data(),
        container = $(this).closest(".profile_notice_item");

      var submitData = datas,
        onSuccess = function (data) {
          if (data.update == true) {
            container.replaceWith(data.notice_html);
          }
        };
      mamamsAjax(submitData, onSuccess, container, "GET");
    };

    const updProfile = function (e) {
      e.preventDefault();

      var serializeArray = $(this).serializeArray(),
        container = $(this);

      // if(serializeArray&&course_type) serializeArray.push({
      // 	name: 'course_type',
      // 	value: course_type
      // });
      console.log("serializeArray", serializeArray);

      var submitData = serializeArray,
        onSuccess = function (data) {
          console.log("data", data);
          if (data.status) container.find(".status").html(data.status);
          if (data.update == true) {
          }
        };
      mamamsAjax(submitData, onSuccess, container, "POST");
    };

    const addChild = function (e) {
      e.preventDefault();

      var btn = $(this).parent(),
        clone = $(".children-item-clone").clone(),
        container = $(".profile-children-list"),
        index = container.find(".item:not(.children-item-clone)").length || 0;

      if (clone) {
        clone.removeClass("children-item-clone").attr("style", "");
        clone.find(".male input").attr("checked", true);
        clone.find("input[data-name]").each(function (i, el) {
          var name = $(this).data("name"),
            key = "children[" + index + "][" + name + "]";
          $(this).attr("name", key);
        });
      }
      
      btn.before(clone);
      var el = btn.prev();
      addChildDropzone(el.find('.child-drop'));
      updProfileChildName();
      updPercentage();
    };

    const removeChild = function (e) {
      e.preventDefault();
      

      $(this).closest('.item').remove();
      const items = $('.profile-children-list ').find(".item:not(.children-item-clone)");
          
      if(items.length) {
        items.each(function(index,item) {
          const inputs = $(item).find('input[data-name]');
          if(inputs.length) {
            inputs.each(function(i,el){
              const name = $(el).data("name"),
                key = "children[" + index + "][" + name + "]";
              $(el).attr("name", key);
            });
          }
        });
      }

      
      updPercentage();
    };

    const AddCustomTheme = function (e) {
      e.preventDefault();

      $(".themes-list .themes-item:not(.themes-item-clone)").each(function (i, el) {
        if ($(this).text() == "") $(this).remove();
      });

      var btn = $(this),
        textarea = btn.prev("textarea"),
        clone = $(".themes-item-clone").clone(),
        container = $(".themes-list");
      // index = container.find('.themes-item:not(.themes-item-clone)').length || 0;

      if (clone && textarea.val() != "") {
        var textareaVal = textarea.val();

        clone.removeClass("themes-item-clone").attr("style", "");
        clone.addClass("active");
        clone.find("input").val(textareaVal);
        clone.find("input").before(textareaVal);
        clone.find("input").prop("checked", true);
        container.append(clone);
        textarea.val("");
        updPercentage();
      }
    };

    function chooseTheme() {
      var input = $(this).find("input"),
        prop = input.prop("checked");
      input.prop("checked", !prop);
      if (!prop) {
        $(this).addClass("active");
      } else {
        $(this).removeClass("active");
      }
    }

    function removeVal() {
      var name = $(this).data("remove");
      if ($('input[name="' + name + '"]').length) {
        $('input[name="' + name + '"]').val("");
      }
    }

    function addChildDropzone(el) {
      $(el).dropzone({
        // autoProcessQueue: false,
        url: window.global.url + '?action=submit_dropzonejs',
        maxFiles: 1,
        thumbnailHeight: 640,
        previewTemplate: "<figure><img data-dz-thumbnail /></figure>",
        init: function() {
  
          var container = $(this.element);
          childDropzoneArr.push(this);
          
            this.on("sending", function(files, xhr, formData) {
              container.addClass("loading");
            });
  
            // this.on("addedfile", function(file) { 
            //   console.log('container', container)
            //   file.previewTemplate = $(this.options.previewTemplate);
            //   console.log('file.previewTemplate', file.previewTemplate)
            //   // this.element.find(".child_avatar_wrap").append(file.previewTemplate);
            //   console.log('this.element', this.element)
            // });
            
    
            this.on("success", function(file, data) {
              console.log('data', data)
  
              if (container) container.removeClass("loading");
  
             if(data) {
               $(container).closest('.item').find('input.child_img').val(data);
             }
              
            });
            
        },
        addRemoveLinks: false,
        thumbnailWidth: 640,
        thumbnailHeight: 640,
        // uploadMultiple: false,
        dictDefaultMessage: "<strong>Drop files here or click to upload. </strong>"
      });
    }

    $(".profile-children-list").on("change", ".item .female input, .item .male input", function () {
      var val = $(this).val() || "";
      $(this).closest(".item").find("figure").attr("class", val);
    });

    $('input[name="first_name"],input[name="last_name"],input[name="age"]').on("input", updName);
    $(".profile-children-list").on("input", ".child_name,.child_age", updChildName);
    $fildsPercentage.on("change", updPercentage);
    $btnAddChil.on("click", addChild);
    $(".profile-children-list").on("click", '.btn_remove_child', removeChild);
    $btnAddTheme.on("click", AddCustomTheme);
    $formProfileInfo.on("submit", updProfile);
    $sidebarProfile.on("click", "[data-notice]", addNotice);
    $sidebarProfile.on("click", "a[data-remove]", removeVal);
    $(".themes-list").on("click", ".themes-item", chooseTheme);

    // console.log('Dropzone', Dropzone.options.myDropzone)

    $('.child-drop').each(function (index,el) {
      addChildDropzone(el);
    });
    
  };

  $(document).ready(function () {

    if(Dropzone) Dropzone.autoDiscover = false;

    if (typeof Profile !== "undefined") {
      var profileObj = new Profile();
    }

    var childDropzone;
    if($('.drop').length){
      var inputDZ = $('.dropzone input');
      $('.drop').dropzone({
          // autoProcessQueue: false,
          url: window.global.url + '?action=submit_dropzonejs',
          maxFiles: 1,
          thumbnailHeight: 640,
          previewsContainer: ".avatar_wrap",
          previewTemplate: "<figure><img data-dz-thumbnail /></figure>",
          // dictRemoveFile: globals.dictRemoveFile,
          // dictCancelUpload: globals.dictCancelUpload,
          init: function() {

              var myDropzone = this,
                  container = $(myDropzone.element);
      
              this.on("sending", function(files, xhr, formData) {
                container.addClass("loading");
              });
      
              this.on("success", function(file, data) {
                console.log('data', data)

                if (container) container.removeClass("loading");

                // var elem = $(this)[0].element;

                if(container.hasClass('profile_main_avatar')&&data) {
                  $.ajax({
                    type: 'POST',
                    url: window.global.url,
                    data: {
                      'action': 'upd_avatar',
                      'img_id': data
                    },
                    dataType: "json",
                    beforeSend: function (response) {
                      // Add loader
                      if (container) container.addClass("loading");
                    },
                    complete: function (response) {
                      if (container) container.removeClass("loading");
                    }
                  });
                }
                
              });
              
          },
          addRemoveLinks: false,
          thumbnailWidth: 640,
          thumbnailHeight: 640,
          // uploadMultiple: false,
          dictDefaultMessage: "<strong>Drop files here or click to upload. </strong>"
        });
    }

    // $("div.drop").dropzone({ url: "/file/post" });

  });
})(jQuery);
