<script setup>
  import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
  import { Head } from "@inertiajs/vue3";
  import { router } from "@inertiajs/vue3";
  import { reactive } from "vue";
  import { Inertia } from "@inertiajs/inertia";
  import ValidationErrors from "@/Components/ValidationErrors.vue";
  import { Core as YubinBangoCore } from "yubinbango-core2";

  defineProps({
    errors: Object,
  });

  const form = reactive({
    name: null,
    kana: null,
    tel: null,
    email: null,
    postcode: null,
    address: null,
    birthday: null,
    gender: null,
    memo: null,
  });

  // fetch address from postal code
  const fetchAddress = () => {
    new YubinBangoCore(String(form.postcode), (value) => {
      // console.log(value);
      form.address = value.region + value.locality + value.street;
    });
  };

  const storeCustomer = () => {
    router.post("/customers", form);
  };
</script>

<template>
  <Head title="顧客登録" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">顧客登録</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <ValidationErrors :errors="errors" />
            <section class="text-gray-600 body-font relative">
              <form action="" @submit.prevent="storeCustomer" :disabled="form.processing">
                <div class="container px-5 py-8 mx-auto">
                  <div class="lg:w-1/2 md:w-2/3 mx-auto">
                    <div class="flex flex-wrap -m-2">
                      <div class="p-2 w-full">
                        <div class="relative">
                          <label for="name" class="leading-7 text-sm text-gray-600"
                            >顧客名(会員名)</label
                          >
                          <input
                            type="text"
                            id="name"
                            name="name"
                            v-model="form.name"
                            class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                          />
                        </div>
                      </div>

                      <div class="p-2 w-full">
                        <div class="relative">
                          <label for="kana" class="leading-7 text-sm text-gray-600"
                            >顧客名カナ</label
                          >
                          <input
                            type="text"
                            id="kana"
                            name="kana"
                            v-model="form.kana"
                            class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                          />
                        </div>
                      </div>

                      <div class="p-2 w-full">
                        <div class="relative">
                          <label for="tel" class="leading-7 text-sm text-gray-600"
                            >電話番号(ハイフンなし)</label
                          >
                          <input
                            type="tel"
                            id="tel"
                            name="tel"
                            v-model="form.tel"
                            class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                          />
                        </div>
                      </div>

                      <div class="p-2 w-full">
                        <div class="relative">
                          <label for="email" class="leading-7 text-sm text-gray-600"
                            >メールアドレス</label
                          >
                          <input
                            type="email"
                            id="email"
                            name="email"
                            v-model="form.email"
                            class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                          />
                        </div>
                      </div>

                      <div class="p-2 w-full">
                        <div class="relative">
                          <label for="postcode" class="leading-7 text-sm text-gray-600"
                            >郵便番号(ハイフンなし)</label
                          >
                          <input
                            type="number"
                            id="postcode"
                            name="postcode"
                            @change="fetchAddress"
                            v-model="form.postcode"
                            class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                          />
                        </div>
                      </div>

                      <div class="p-2 w-full">
                        <div class="relative">
                          <label for="address" class="leading-7 text-sm text-gray-600"
                            >住所</label
                          >
                          <input
                            type="text"
                            id="address"
                            name="address"
                            v-model="form.address"
                            class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                          />
                        </div>
                      </div>

                      <div class="p-2 w-full">
                        <div class="relative">
                          <label for="birthday" class="leading-7 text-sm text-gray-600"
                            >誕生日</label
                          >
                          <input
                            type="date"
                            id="birthday"
                            name="birthday"
                            v-model="form.birthday"
                            class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                          />
                        </div>
                      </div>

                      <div class="p-2 w-full">
                        <div class="relative">
                          <label class="leading-7 text-sm text-gray-600">性別</label>
                          <input
                            type="radio"
                            id="gender0"
                            name="gender"
                            v-model="form.gender"
                            value="0"
                          />
                          <label for="gender0" class="ml-2 mr-4">男性</label>
                          <input
                            type="radio"
                            id="gender1"
                            name="gender"
                            v-model="form.gender"
                            value="1"
                          />
                          <label for="gender1" class="ml-2 mr-4">女性</label>
                          <input
                            type="radio"
                            id="gender2"
                            name="gender"
                            v-model="form.gender"
                            value="2"
                          />
                          <label for="gender2" class="ml-2 mr-4">その他</label>
                        </div>
                      </div>

                      <div class="p-2 w-full">
                        <div class="relative">
                          <label for="memo" class="leading-7 text-sm text-gray-600"
                            >メモ</label
                          >
                          <textarea
                            id="memo"
                            name="memo"
                            v-model="form.memo"
                            class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"
                          ></textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="p-2 w-full">
                  <button
                    type="submit"
                    class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg"
                  >
                    顧客登録
                  </button>
                </div>
              </form>
            </section>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
