<script>
import { Link, useForm } from "@inertiajs/vue3";
import Swal from "sweetalert2";
import Pagination from "@/Shared/Pagination.vue";
import LayoutMain from "@/layouts/LayoutMain.vue";
import {
  mdiMonitorCellphone,
  mdiTableBorder,
  mdiTableOff,
  mdiGithub,
  mdiEye,
  mdiTrashCan,
} from "@mdi/js";
import TableSampleClients from "@/components/TableSampleClients.vue";
import CardBox from "@/components/CardBox.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import BaseLevel from "@/components/BaseLevel.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import BaseButton from "@/components/BaseButton.vue";
import CardBoxComponentEmpty from "@/components/CardBoxComponentEmpty.vue";
import LayoutWelcome from "@/layouts/LayoutWelcome.vue";
import axios from "axios";
import PillTag from "@/components/PillTag.vue";
import moment from "moment";

export default {
  props: {
    records: {
      type: Object,
      required: true,
    },
  },
  components: {
    Link,
    LayoutMain,
    CardBox,
    TableSampleClients,
    SectionTitleLineWithButton,
    BaseLevel,
    BaseButtons,
    BaseButton,
    CardBoxComponentEmpty,
    Pagination,
    LayoutWelcome,
    PillTag,
  },
  methods: {
    getDate(date_start, date_end) {
      const current = new Date();

      const isMajor = m_date => m_date > 10;
      const day = isMajor(current.getDate()) ? current.getDate() : '0' + current.getDate();

      const date = `${current.getFullYear()}-0${current.getMonth() + 1}-${day}`;

      console.log(date)

      if (date >= date_start && date <= date_end) {
        return true
      }
      else {
        return false
      }
    },
    getPdf(filename, announcement) {
      axios({
        url: "/download-AdPdf/" + (filename + ".pdf") + "/" + announcement,
        method: "GET",
        responseType: "blob", // This is important
      }).then((response) => {
        const url = window.URL.createObjectURL(new Blob([response.data]));
        const link = document.createElement("a");
        console.log(url);
        link.href = url;
        link.setAttribute("download", filename + ".pdf");
        document.body.appendChild(link);
        link.click();
      });
    },
    convertTimeFormatDay(time) {
      const formattedDate = moment(time).format("DD");
      return formattedDate;
    },
    convertTimeFormatMonth(time) {
      const formattedDate = moment(time).format("MMMM");
      return formattedDate;
    },
  },
  setup() {
    return {
      mdiMonitorCellphone,
      mdiTableBorder,
      mdiTableOff,
      mdiGithub,
      mdiEye,
      mdiTrashCan,
      PillTag,
    };
  },
};
</script>

<template>
  <LayoutWelcome>
    <CardBox class="mx-12 mt-24 max-xl:m-4 max-lg:mt-8" v-if="records.length < 1">
      <CardBoxComponentEmpty />
    </CardBox>

    <div v-else class="w-full">
      <div class="mt-16 mx-5">
        <div class="divide-y divide-gray-200 dark:divide-gray-700">
          <div class="space-y-2 pb-8 pt-6 md:space-y-5">
            <h1
              class="text-3xl font-extrabold leading-9 tracking-tight text-gray-900 dark:text-gray-100 sm:text-4xl sm:leading-10 md:text-6xl md:leading-14">
              Convocatorias
            </h1>
            <p class="text-lg leading-7 text-gray-500 dark:text-gray-400">
              Lo ultimo en la plataforma!
            </p>
          </div>
          <ul class="divide-y divide-gray-200 dark:divide-gray-700">
            <li class="py-8" v-for="(item, index) in records" :key="index">
              <article class="border-x-4	px-8">
                <div class="space-y-2 xl:grid xl:grid-cols-4 xl:items-baseline xl:space-y-0">
                  <dl>
                    <dt class="sr-only">Publicado en</dt>
                    <dd class="text-base font-medium leading-6 text-gray-500 dark:text-gray-400">
                      <time datetime="2023-08-05T00:00:00.000Z">{{ item.calendars[0].date_start }}</time>
                    </dd>
                  </dl>
                  <div class="space-y-4 xl:col-span-3 ">
                    <div class="space-y-8">
                      <div class="space-y-2">
                        <h2 class="text-2xl font-bold leading-8 tracking-tight">
                          <a class="text-gray-900 dark:text-gray-100"
                            href="/blog/release-of-tailwind-nextjs-starter-blog-v2.0">{{ item.name }}</a>
                        </h2>
                        <div class="flex flex-wrap">
                          <a v-if="
                            getDate(item.calendars[1].date_start, item.calendars[1].date_end)
                          ">
                            <PillTag color="success" label="Inscripcion de laboratorios" :small="false" :outline="false"
                              :icon="pillsIcon" />
                          </a>
                          <a v-else-if="
                            getDate(item.calendars[2].date_start, item.calendars[2].date_end)
                          ">
                            <PillTag color="warning" label="Laboratorios en evaluacion" :small="false" :outline="false"
                              :icon="pillsIcon" />
                          </a>
                          <a v-else>
                            <PillTag color="danger" label="Convocatoria Cerrada" :small="false" :outline="false"
                              :icon="pillsIcon" />
                          </a>
                        </div>
                      </div>
                      <div class="prose max-w-none text-gray-500 dark:text-gray-400">
                        {{ item.description }}
                      </div>
                    </div>
                    <div class="text-base font-medium leading-6">
                      <div class="flex flex-row space-x-2">
                        <a v-if="getDate(item.calendars[1].date_start, item.calendars[1].date_end)"
                          :href="route('proposals.show', item.id)">
                          <PillTag color="success" label="Inscribirse" :small="false" :outline="false"
                            :icon="pillsIcon" />
                        </a>
                        <div @click="getPdf('advertising', item.name)">
                          <PillTag color="info" label="Descargar" :small="false" :outline="false" :icon="pillsIcon" />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </article>
            </li>




          </ul>
        </div>
        <!--    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
          <div
            v-for="item in records"
            :key="item.id"
            class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500"
          >
            <div>
              <span>
                <div
                  class="h-16 w-16 bg-red-50 dark:bg-red-800/20 flex items-center justify-center rounded-full"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    class="w-7 h-7 stroke-red-500"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"
                    />
                  </svg>
                </div>
                Convocatoria
              </span>

              <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">
                {{ item.name }}
                <span class="text-lg text-gray-700 dark:text-gray-400">
                  {{ convertTimeFormatMonth(item.created_at) }}
                </span>
              </h2>

              <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                {{ item.description }}
              </p>
            </div>
            <div class="px-12 flex flex-row space-x-2">
              <div
                v-if="getDate(item.calendars[0].date_start, item.calendars[0].date_end)"
              ></div>
              <a
                v-if="getDate(item.calendars[1].date_start, item.calendars[1].date_end)"
                :href="route('proposals.show', item.id)"
                class="w-full"
              >
                <PillTag
                  color="success"
                  label="Inscribirse"
                  :small="false"
                  :outline="false"
                  :icon="pillsIcon"
                />
              </a>
              <a
                v-else-if="
                  getDate(item.calendars[2].date_start, item.calendars[2].date_end)
                "
              >
                <PillTag
                  color="warning"
                  label="Propuestas en evaluacion"
                  :small="false"
                  :outline="false"
                  :icon="pillsIcon"
                />
              </a>
              <a v-else>
                <PillTag
                  color="danger"
                  label="Convocatoria Cerrada"
                  :small="false"
                  :outline="false"
                  :icon="pillsIcon"
                />
              </a>
              <div @click="getPdf('advertising', item.name)">
                <PillTag
                  color="info"
                  label="Descargar"
                  :small="false"
                  :outline="false"
                  :icon="pillsIcon"
                />
              </div>
            </div>
          </div>
        </div> -->
      </div>
    </div>
  </LayoutWelcome>
</template>
