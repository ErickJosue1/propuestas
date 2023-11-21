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
      console.log(date_start, date_end);

      const isMajor = (m_date) => m_date >= 10;
      const day = isMajor(current.getDate())
        ? current.getDate()
        : "0" + current.getDate();
      const month = isMajor(current.getMonth() + 1)
        ? current.getMonth() + 1
        : "0" + current.getMonth();

      const date = `${current.getFullYear()}-${month}-${day}`;
      console.log(date);
      if (date >= date_start && date <= date_end) {
        return true;
      } else {
        return false;
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
              class="text-3xl font-extrabold leading-9 tracking-tight text-gray-900 dark:text-gray-100 sm:text-4xl sm:leading-10 md:text-6xl md:leading-14"
            >
              Latest
            </h1>
            <p class="text-lg leading-7 text-gray-500 dark:text-gray-400">
              A blog created with Next.js and Tailwind.css
            </p>
          </div>
          <ul class="divide-y divide-gray-200 dark:divide-gray-700">
            <li class="py-12">
              <article>
                <div
                  class="space-y-2 xl:grid xl:grid-cols-4 xl:items-baseline xl:space-y-0"
                >
                  <dl>
                    <dt class="sr-only">Published on</dt>
                    <dd
                      class="text-base font-medium leading-6 text-gray-500 dark:text-gray-400"
                    >
                      <time datetime="2023-08-05T00:00:00.000Z">August 5, 2023</time>
                    </dd>
                  </dl>
                  <div class="space-y-5 xl:col-span-3">
                    <div class="space-y-6">
                      <div>
                        <h2 class="text-2xl font-bold leading-8 tracking-tight">
                          <a
                            class="text-gray-900 dark:text-gray-100"
                            href="/blog/release-of-tailwind-nextjs-starter-blog-v2.0"
                            >Release of Tailwind Nextjs Starter Blog v2.0</a
                          >
                        </h2>
                        <div class="flex flex-wrap">
                          <a
                            class="mr-3 text-sm font-medium uppercase text-primary-500 hover:text-primary-600 dark:hover:text-primary-400"
                            href="/tags/next-js"
                            >next-js</a
                          ><a
                            class="mr-3 text-sm font-medium uppercase text-primary-500 hover:text-primary-600 dark:hover:text-primary-400"
                            href="/tags/tailwind"
                            >tailwind</a
                          ><a
                            class="mr-3 text-sm font-medium uppercase text-primary-500 hover:text-primary-600 dark:hover:text-primary-400"
                            href="/tags/guide"
                            >guide</a
                          ><a
                            class="mr-3 text-sm font-medium uppercase text-primary-500 hover:text-primary-600 dark:hover:text-primary-400"
                            href="/tags/feature"
                            >feature</a
                          >
                        </div>
                      </div>
                      <div class="prose max-w-none text-gray-500 dark:text-gray-400">
                        Release of Tailwind Nextjs Starter Blog template v2.0, refactored
                        with Nextjs App directory and React Server Components
                        setup.Discover the new features and how to migrate from V1.
                      </div>
                    </div>
                    <div class="text-base font-medium leading-6">
                      <a
                        class="text-primary-500 hover:text-primary-600 dark:hover:text-primary-400"
                        aria-label='Read more: "Release of Tailwind Nextjs Starter Blog v2.0"'
                        href="/blog/release-of-tailwind-nextjs-starter-blog-v2.0"
                        >Read more →</a
                      >
                    </div>
                  </div>
                </div>
              </article>
            </li>
            <li class="py-12">
              <article>
                <div
                  class="space-y-2 xl:grid xl:grid-cols-4 xl:items-baseline xl:space-y-0"
                >
                  <dl>
                    <dt class="sr-only">Published on</dt>
                    <dd
                      class="text-base font-medium leading-6 text-gray-500 dark:text-gray-400"
                    >
                      <time datetime="2021-08-07T15:32:14.000Z">August 7, 2021</time>
                    </dd>
                  </dl>
                  <div class="space-y-5 xl:col-span-3">
                    <div class="space-y-6">
                      <div>
                        <h2 class="text-2xl font-bold leading-8 tracking-tight">
                          <a
                            class="text-gray-900 dark:text-gray-100"
                            href="/blog/new-features-in-v1"
                            >New features in v1</a
                          >
                        </h2>
                        <div class="flex flex-wrap">
                          <a
                            class="mr-3 text-sm font-medium uppercase text-primary-500 hover:text-primary-600 dark:hover:text-primary-400"
                            href="/tags/next-js"
                            >next-js</a
                          ><a
                            class="mr-3 text-sm font-medium uppercase text-primary-500 hover:text-primary-600 dark:hover:text-primary-400"
                            href="/tags/tailwind"
                            >tailwind</a
                          ><a
                            class="mr-3 text-sm font-medium uppercase text-primary-500 hover:text-primary-600 dark:hover:text-primary-400"
                            href="/tags/guide"
                            >guide</a
                          >
                        </div>
                      </div>
                      <div class="prose max-w-none text-gray-500 dark:text-gray-400">
                        An overview of the new features released in v1 - code block copy,
                        multiple authors, frontmatter layout and more
                      </div>
                    </div>
                    <div class="text-base font-medium leading-6">
                      <a
                        class="text-primary-500 hover:text-primary-600 dark:hover:text-primary-400"
                        aria-label='Read more: "New features in v1"'
                        href="/blog/new-features-in-v1"
                        >Read more →</a
                      >
                    </div>
                  </div>
                </div>
              </article>
            </li>
            <li class="py-12">
              <article>
                <div
                  class="space-y-2 xl:grid xl:grid-cols-4 xl:items-baseline xl:space-y-0"
                >
                  <dl>
                    <dt class="sr-only">Published on</dt>
                    <dd
                      class="text-base font-medium leading-6 text-gray-500 dark:text-gray-400"
                    >
                      <time datetime="2021-05-02T00:00:00.000Z">May 2, 2021</time>
                    </dd>
                  </dl>
                  <div class="space-y-5 xl:col-span-3">
                    <div class="space-y-6">
                      <div>
                        <h2 class="text-2xl font-bold leading-8 tracking-tight">
                          <a
                            class="text-gray-900 dark:text-gray-100"
                            href="/blog/nested-route/introducing-multi-part-posts-with-nested-routing"
                            >Introducing Multi-part Posts with Nested Routing</a
                          >
                        </h2>
                        <div class="flex flex-wrap">
                          <a
                            class="mr-3 text-sm font-medium uppercase text-primary-500 hover:text-primary-600 dark:hover:text-primary-400"
                            href="/tags/multi-author"
                            >multi-author</a
                          ><a
                            class="mr-3 text-sm font-medium uppercase text-primary-500 hover:text-primary-600 dark:hover:text-primary-400"
                            href="/tags/next-js"
                            >next-js</a
                          ><a
                            class="mr-3 text-sm font-medium uppercase text-primary-500 hover:text-primary-600 dark:hover:text-primary-400"
                            href="/tags/feature"
                            >feature</a
                          >
                        </div>
                      </div>
                      <div class="prose max-w-none text-gray-500 dark:text-gray-400">
                        The blog template supports posts in nested sub-folders. This can
                        be used to group posts of similar content e.g. a multi-part
                        course. This post is itself an example of a nested route!
                      </div>
                    </div>
                    <div class="text-base font-medium leading-6">
                      <a
                        class="text-primary-500 hover:text-primary-600 dark:hover:text-primary-400"
                        aria-label='Read more: "Introducing Multi-part Posts with Nested Routing"'
                        href="/blog/nested-route/introducing-multi-part-posts-with-nested-routing"
                        >Read more →</a
                      >
                    </div>
                  </div>
                </div>
              </article>
            </li>
            <li class="py-12">
              <article>
                <div
                  class="space-y-2 xl:grid xl:grid-cols-4 xl:items-baseline xl:space-y-0"
                >
                  <dl>
                    <dt class="sr-only">Published on</dt>
                    <dd
                      class="text-base font-medium leading-6 text-gray-500 dark:text-gray-400"
                    >
                      <time datetime="2021-01-12T00:00:00.000Z">January 12, 2021</time>
                    </dd>
                  </dl>
                  <div class="space-y-5 xl:col-span-3">
                    <div class="space-y-6">
                      <div>
                        <h2 class="text-2xl font-bold leading-8 tracking-tight">
                          <a
                            class="text-gray-900 dark:text-gray-100"
                            href="/blog/introducing-tailwind-nextjs-starter-blog"
                            >Introducing Tailwind Nextjs Starter Blog</a
                          >
                        </h2>
                        <div class="flex flex-wrap">
                          <a
                            class="mr-3 text-sm font-medium uppercase text-primary-500 hover:text-primary-600 dark:hover:text-primary-400"
                            href="/tags/next-js"
                            >next-js</a
                          ><a
                            class="mr-3 text-sm font-medium uppercase text-primary-500 hover:text-primary-600 dark:hover:text-primary-400"
                            href="/tags/tailwind"
                            >tailwind</a
                          ><a
                            class="mr-3 text-sm font-medium uppercase text-primary-500 hover:text-primary-600 dark:hover:text-primary-400"
                            href="/tags/guide"
                            >guide</a
                          >
                        </div>
                      </div>
                      <div class="prose max-w-none text-gray-500 dark:text-gray-400">
                        Looking for a performant, out of the box template, with all the
                        best in web technology to support your blogging needs? Checkout
                        the Tailwind Nextjs Starter Blog template.
                      </div>
                    </div>
                    <div class="text-base font-medium leading-6">
                      <a
                        class="text-primary-500 hover:text-primary-600 dark:hover:text-primary-400"
                        aria-label='Read more: "Introducing Tailwind Nextjs Starter Blog"'
                        href="/blog/introducing-tailwind-nextjs-starter-blog"
                        >Read more →</a
                      >
                    </div>
                  </div>
                </div>
              </article>
            </li>
            <li class="py-12">
              <article>
                <div
                  class="space-y-2 xl:grid xl:grid-cols-4 xl:items-baseline xl:space-y-0"
                >
                  <dl>
                    <dt class="sr-only">Published on</dt>
                    <dd
                      class="text-base font-medium leading-6 text-gray-500 dark:text-gray-400"
                    >
                      <time datetime="2020-12-21T00:00:00.000Z">December 21, 2020</time>
                    </dd>
                  </dl>
                  <div class="space-y-5 xl:col-span-3">
                    <div class="space-y-6">
                      <div>
                        <h2 class="text-2xl font-bold leading-8 tracking-tight">
                          <a
                            class="text-gray-900 dark:text-gray-100"
                            href="/blog/deriving-ols-estimator"
                            >Deriving the OLS Estimator</a
                          >
                        </h2>
                        <div class="flex flex-wrap">
                          <a
                            class="mr-3 text-sm font-medium uppercase text-primary-500 hover:text-primary-600 dark:hover:text-primary-400"
                            href="/tags/next-js"
                            >next-js</a
                          ><a
                            class="mr-3 text-sm font-medium uppercase text-primary-500 hover:text-primary-600 dark:hover:text-primary-400"
                            href="/tags/math"
                            >math</a
                          ><a
                            class="mr-3 text-sm font-medium uppercase text-primary-500 hover:text-primary-600 dark:hover:text-primary-400"
                            href="/tags/ols"
                            >ols</a
                          >
                        </div>
                      </div>
                      <div class="prose max-w-none text-gray-500 dark:text-gray-400">
                        How to derive the OLS Estimator with matrix notation and a tour of
                        math typesetting using markdown with the help of KaTeX.
                      </div>
                    </div>
                    <div class="text-base font-medium leading-6">
                      <a
                        class="text-primary-500 hover:text-primary-600 dark:hover:text-primary-400"
                        aria-label='Read more: "Deriving the OLS Estimator"'
                        href="/blog/deriving-ols-estimator"
                        >Read more →</a
                      >
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
