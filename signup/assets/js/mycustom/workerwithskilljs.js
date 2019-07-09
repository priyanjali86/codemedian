var myArray = [];
$.widget("ui.autocomplete", $.ui.autocomplete, {
    options : $.extend({}, this.options, {
        multiselect: false
    }),
    _create: function(){
        this._super();

        var self = this,
            o = self.options;

        if (o.multiselect) {
            console.log('multiselect true');

            self.selectedItems = {};           
            self.multiselect = $("<div></div>")
                .addClass("ui-autocomplete-multiselect ui-state-default ui-widget")
                .css("width", self.element.width())
                .insertBefore(self.element)
                .append(self.element)
                .bind("click.autocomplete", function(){
                    self.element.focus();
                });
            
            var fontSize = parseInt(self.element.css("fontSize"), 10);
            function autoSize(e){
                var $this = $(this);
                $this.width(1).width(this.scrollWidth+fontSize-1);
            };

            var kc = $.ui.keyCode;
            self.element.bind({
                "keydown.autocomplete": function(e){
                    if ((this.value === "") && (e.keyCode == kc.BACKSPACE)) {
                        var prev = self.element.prev();
                        delete self.selectedItems[prev.text()];
                        prev.remove();
                    }
                },
                "focus.autocomplete blur.autocomplete": function(){
                    self.multiselect.toggleClass("ui-state-active");
                },
                "keypress.autocomplete change.autocomplete focus.autocomplete blur.autocomplete": autoSize
            }).trigger("change");

            o.select = function(e, ui) {
                $("<div></div>")
                    .addClass("ui-autocomplete-multiselect-item")
                    .text(ui.item.label)
                    .append(
                        $("<span></span>")
                        .addClass("ui-icon ui-icon-close")
                        .click(function(){
                            var item = $(this).parent();

                            delete self.selectedItems[item.text()];
                            var list = $('#myresult').val();
                            var value = item.text();
                            var separator = ',';

                            separator = separator || ",";
                            var values = list.split(separator);
                            for(var i = 0 ; i < values.length ; i++) {
                                if(values[i] == value) {
                                  values.splice(i, 1);
                                  values.join(separator);
                              }
                          }

                          var index = myArray.indexOf(value);
                          if (index !== -1) myArray.splice(index, 1);
                          $('#myresult').val(values);
                          $('#myskill').val(values);
                          item.remove();
                      })
                        )
                    .insertBefore(self.element);
                
                self.selectedItems[ui.item.label] = ui.item;
                self._value("");
                 myArray.push(ui.item.value);
                 $('#myresult').val(myArray);
                 $('#myskill').val(myArray);
                 
                return false;
            }
        }

        return this;
    }
});

