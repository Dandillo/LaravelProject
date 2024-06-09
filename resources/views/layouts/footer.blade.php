<footer class="w-full bg-gray-900 mt-14">
    <div style="max-width: 1280px;" class="m-auto">
        <div class="py-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 text-white">
            <div class="w-full p-3">
                <p class="mb-4 sm:text-caption-regular text-body font-bold text-footer-headers">Контакты</p>

                <x-logo class="block h-10 w-auto m-auto fill-current text-white"/>

                <div>
                    <div class="mb-3">
                        <a href="mailto:cdc@scitech.ru" class="underline">cdc@scitech.ru</a>
                    </div>
                    <a href="mailto:neustroev.denis@sibnoc.ru ">
                        <p class="mb-1">Тюмень — Сургут</p>
                        <p class="underline">cdc@scitech.ru</p><br>
                    </a>
                    <div class="flex gap-6">
                        <x-soc-link href="https://www.facebook.com/cdcscitech">
                            <i class="fab fa-facebook-f"></i>
                        </x-soc-link>
                        <x-soc-link href="https://vk.com/public202354376">
                            <i class="fab fa-vk"></i>
                        </x-soc-link>
                        <x-soc-link href="https://www.instagram.com/scitech.ru/">
                            <i class="fab fa-instagram"></i>
                        </x-soc-link>
                        <x-soc-link href="https://t.me/scitechru">
                            <i class="fab fa-telegram-plane"></i>
                        </x-soc-link>
                    </div>
                </div>
            </div>
            <div class="w-full hidden sm:block p-3">
                <div>
                    <p class="mb-4 sm:text-caption-regular text-body font-bold text-footer-headers">Наши партнеры</p>
{{--                    <p class="mb-1">Компания 1</p>--}}
{{--                    <p class="mb-1">Компания 2</p>--}}
{{--                    <p class="mb-1">Компания 3</p>--}}
                </div>
            </div>
            <div class="w-full p-3">
                <div>
                    <p class="sm:text-caption-regular text-body font-bold text-footer-headers">Подпишитесь на нашу
                        рассылку</p>
                    <small>Получайте уведомления о новых проектах и бонусах прямо на почту</small>
                    <div class="mt-4">
                        <form class="flex items-center mb-6 ">
                            <x-input type="email" placeholder="Ваш E-mail" class="text-sm mr-2"></x-input>
                            <button class="bg-accent-blue w-9 p-3 flex-shrink-0" style="height:38px;"></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
