/**
 * Плагин галереи для страницы новостей Максима Дубина
 * @author InviS
 * 04.07.2011
 */

(function($){
	$.fn.newsGalery = function(options){
		var options = $.extend({
			fadeDuration: 800,
			slideDuration: 6000
		}, options || {});
		
		var $this = this;
		var $thumbs = $this.find('li');
		/** просмотрщик фото */
		var $viewer = $('#photo-viewer');
		var $photos = $viewer.find('.photos li');
		
		var Vars = {
			/** id отображаемой новости */
			newsId: 0,
			/** текущее фото */
			currentPhoto : 0,
			/** кол-во фотографий в галерее */
			maxPhoto: 0
		}
		
		var Functions = {
			/** корректируем введенное число, чтоб не превышало кол-во слайдов */
			correctSlideNum: function(num){
				var max = Vars.maxPhoto;
				if (num > max - 1)  num = num % max;
				if (num < 0) {
					num = Math.abs(num) % max;
					num = max - num;
				}
				return num;
			}
		}
		
		/** функции галереи */
		var Galery = {
			/** инициализируем галерею */
			init: function(){
				Vars.currentPhoto = $thumbs.index($(this));
				Vars.newsId = $(this).parent().data('id');
				Vars.maxPhoto = $photos.length;
				// показываем просмотрщик
				$photos.eq(Vars.currentPhoto).show();
				$viewer.show();
				// добавляем обработку клавиш клавиатуры и кнопок
				Keyboard.init();
				Buttons.init();
				Buttons.disable();
			},
			/** закрытие галереи */
			close: function(){
				Keyboard.shutDown();
				$viewer.hide();
				$photos.hide();
			},
			/** смена слайда */
			changeSlide: function(slide){
				slide = Functions.correctSlideNum(slide);
				$photos.filter(':visible').fadeOut(options.fadeDuration, function(){
					$photos.eq(slide).fadeIn(options.fadeDuration);
					Vars.currentPhoto = slide;
					Buttons.disable();
				});
			},
			/** следующее фото */
			next: function(){
				if (Buttons.next.hasClass('disabled')) return false;
				Galery.changeSlide(Vars.currentPhoto + 1);
				return false;
			},
			/** предыдущее фото */
			prev: function(){
				if (Buttons.prev.hasClass('disabled')) return false;
				Galery.changeSlide(Vars.currentPhoto - 1);
				return false;
			}
		}
		
		/** клавиатура */
		var Keyboard = {
			/** инициализируем клавиатуру */
			init: function(){
				$(document).bind('keyup',function(e){
					switch (e.keyCode){
						case 37: Galery.prev(); break;
						case 39: Galery.next(); break;
						case 27: Galery.close(); break;						
					}
				});
			},
			/** убираем зарезервированные клавиши */
			shutDown: function(){
				$(document).unbind('keyup');
			}
		}
		
		/** Кнопки */
		var Buttons = {
			/** кнопка - вернуться назад */
			back: $viewer.find('.back-btn'),
			next: $viewer.find('.pagination li').eq(1).find('a'),
			prev: $viewer.find('.pagination li').eq(0).find('a'),
			/** инициализируем кнопки */
			init: function(){
				Buttons.back.bind('click',Galery.close);
				Buttons.next.bind('click',Galery.next);
				Buttons.prev.bind('click',Galery.prev);
			},
			/** убираем зарезервированные кнопки */
			shutDown: function(){
				Buttons.back.unbind('click');
				Buttons.next.unbind('click');
				Buttons.prev.unbind('click');
			},
			/** блокируем/разблокируем кнопки */
			disable: function(){
				if (Vars.currentPhoto == Vars.maxPhoto - 1){
					Buttons.next.addClass('disabled');
				} else {
					Buttons.next.removeClass('disabled');
				}
				if (Vars.currentPhoto == 0){
					Buttons.prev.addClass('disabled');
				} else {
					Buttons.prev.removeClass('disabled');
				}
			}
		}
		
		
		/** события */
		$thumbs.bind('click',Galery.init);
		
		return this;
	}
})(jQuery);
