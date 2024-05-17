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
  mounted() {
    let Script = document.createElement('script')
    Script.setAttribute('src', 'https://unpkg.com/tailwindcss-jit-cdn')
    document.head.appendChild(Script)
  },
  data() {
    return {
      imageUrls: {}  // Arreglo para almacenar las URLs de las imágenes
    };
  },
  methods: {
    viewImageForAll() {
      this.records.data.forEach(async item => {

        var response = await this.viewImage(item.name, "png");

        if (response) {
          console.log("succ")
        } {
          await this.viewImage(item.name, "jpg");
        }
      });
    },
    async viewImage(announcement, format) {

      var catched = true;

      try {
        const response = await axios({
          url: '/view-image/' + ("cover." + format) + '/' + announcement,
          method: 'GET',
          responseType: 'blob',
        }).then(response => {
          const blob = new Blob([response.data], { type: response.headers['content-type'] });
          const link = URL.createObjectURL(blob);

          this.imageUrls[announcement] = link;
        })

        console.log(response)
      } catch (error) {

        return false;
      }

    },
    getDate(date_start, date_end) {
      const current = new Date();

      const isMajor = m_date => m_date > 10;
      const day = isMajor(current.getDate()) ? current.getDate() : '0' + current.getDate();

      const date = `${current.getFullYear()}-0${current.getMonth() + 1}-${day}`;


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

  created() {
    this.viewImageForAll();
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
    <CardBox class="mx-12 mt-24 max-xl:m-4 max-lg:mt-8" v-if="records.data.length < 1">
      <CardBoxComponentEmpty />
    </CardBox>

    <body class="antialiasedfont-sans p-6">
      <div class="container mx-auto">
        <div class="flex flex-wrap -mx-4">
          <div v-for="item in records.data" class="w-full sm:w-1/2 md:w-1/2 xl:w-1/4 p-4 ">
            <div class="c-card block shadow-md hover:shadow-xl rounded-lg overflow-hidden dark:bg-slate-700">
              <div class="relative pb-48 overflow-hidden">
                <img class="absolute inset-0 h-full w-full object-cover" :src="imageUrls[item.name]" alt="">
              </div>

              <div class="p-4">
                <div class="flex flex-wrap">
                  <a v-if="
                    getDate(item.calendars[0].date_start, item.calendars[0].date_end)
                  ">
                    <PillTag color="success" label="Inscripcion de laboratorios" :small="false" :outline="false" />
                  </a>
                  <a v-else-if="
                    getDate(item.calendars[1].date_start, item.calendars[1].date_end)
                  ">
                    <PillTag color="success" label="Inscripcion de laboratorios" :small="false" :outline="false" />
                  </a>
                  <a v-else-if="
                    getDate(item.calendars[2].date_start, item.calendars[2].date_end)
                  ">
                    <PillTag color="warning" label="Laboratorios en evaluacion" :small="false" :outline="false" />
                  </a>
                  <a v-else>
                    <PillTag color="danger" label="Convocatoria Cerrada" :small="false" :outline="false" />
                  </a>
                </div>
                <h2 class="mt-2 mb-2 font-bold">{{ item.name }}</h2>
                <p class="text-sm">{{ item.description }}</p>
                <div class="mt-3 flex items-center">
                  <span class="text-sm font-semibold">Fecha</span>&nbsp;<span class="font-bold text-xl">{{
                    item.calendars[0].date_start }}</span>&nbsp;<span class="text-sm font-semibold"></span>
                </div>
              </div>
              <div class="p-4 border-t border-b text-xs ">
                <span class="flex items-center mb-1">
                  <i class="far fa-clock fa-fw mr-2 "></i> Institucion
                </span>
                <span class="flex items-center">
                  <i class="far fa-address-card fa-fw  mr-2"></i> {{ item.institutions.name }}
                </span>
              </div>
              <div class="text-base font-medium leading-6 px-4 py-4">
                <div class="flex flex-row space-x-2">
                  <a v-if="getDate(item.calendars[1].date_start, item.calendars[1].date_end) || getDate(item.calendars[0].date_start, item.calendars[0].date_end)"
                    :href="route('proposals.show', item.id)">
                    <PillTag color="success" label="Inscribirse" :small="false" :outline="false" />
                  </a>
                  <div class="cursor-pointer" @click="getPdf('advertising', item.name)">
                    <PillTag color="info" label="Descargar" :small="false" :outline="false" />
                  </div>
                </div>
              </div>
            </div>
          </div>


        </div>
      </div>

      <Pagination :currentPage="records.current_page" :links="records.links" :total="records.links.length - 2">
      </Pagination>

    </body>


  </LayoutWelcome>
</template>

<style>
.c-card {
  img {
    transition: transform .3s ease-in-out;
  }

  &:hover {
    img {
      transform: scale(1.05)
    }
  }
}
</style>