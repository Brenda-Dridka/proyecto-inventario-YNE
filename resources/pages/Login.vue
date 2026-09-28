<script setup>
import { ref } from "vue";
import axios from "axios";
import { toast } from "vue3-toastify";
import { useRouter } from "vue-router";

const router = useRouter();

const form = ref({
    no_empleado: "",
    password: "",
});

const cargando = ref(false);
const mostrarPassword = ref(false);

const iniciarSesion = async () => {
    if (!form.value.no_empleado || !form.value.password) {
        toast.error("Ingresa tu número de nómina y contraseña.");
        return;
    }

    cargando.value = true;

    try {
        const response = await axios.post("/api/login", {
            no_empleado: form.value.no_empleado,
            password: form.value.password,
        });

        const usuario = response.data.data;

        // Guardar sesión
        localStorage.setItem("usuario", JSON.stringify(usuario));

        toast.success("Inicio de sesión correcto.");

        // Ir al Dashboard
        router.replace({
            name: "dashboard",
        });
    } catch (error) {
        console.error("Error al iniciar sesión:", error);

        if (error.response?.status === 422) {
            const errores = error.response.data.errors;
            const primerError = Object.values(errores)[0]?.[0];

            toast.error(primerError || "Verifica los datos ingresados.");

            return;
        }

        if (error.response?.status === 401) {
            toast.error("El número de nómina o la contraseña son incorrectos.");

            return;
        }

        if (error.response?.status === 403) {
            toast.error(
                error.response.data.message ||
                    "El usuario se encuentra inactivo.",
            );

            return;
        }

        toast.error("Ocurrió un error al intentar iniciar sesión.");
    } finally {
        cargando.value = false;
    }
};
</script>

<template>
    <div class="min-h-screen bg-[#f7f8ff] lg:flex">
        <!-- =====================================================
             PANEL IZQUIERDO
        ====================================================== -->
        <section
            class="relative hidden min-h-screen overflow-hidden lg:flex lg:w-[52%]"
        >
            <!-- Imagen del almacén -->
            <div
                class="absolute inset-0 bg-cover bg-center"
                style="
                    background: url(&quot;https://i.pinimg.com/736x/2f/dc/19/2fdc197fd5fa8a9aafcea6c71d5db789.jpg&quot;);
                "
            ></div>

            <!-- Overlay azul / morado -->
            <div
                class="absolute inset-0 bg-gradient-to-br from-[#2563eb]/90 via-[#4f46e5]/80 to-[#8b5cf6]/90"
            ></div>

            <!-- Efectos decorativos -->
            <div
                class="absolute -bottom-32 -left-20 h-96 w-96 rounded-full bg-violet-400/30 blur-3xl"
            ></div>

            <div
                class="absolute -right-32 top-20 h-80 w-80 rounded-full bg-blue-300/20 blur-3xl"
            ></div>

            <!-- Contenido -->
            <div
                class="relative z-10 flex w-full flex-col justify-between p-10 xl:p-14"
            >
                <!-- Logo -->
                <div class="flex items-center gap-4">
                    <div
                        class="flex h-14 w-14 items-center justify-center rounded-2xl border border-white/30 bg-white/15 shadow-xl backdrop-blur-md"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-7 w-7 text-white"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 3l8 4.5v9L12 21l-8-4.5v-9L12 3z"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M4 7.5l8 4.5 8-4.5M12 12v9"
                            />
                        </svg>
                    </div>

                    <div>
                        <h2
                            class="text-2xl font-bold tracking-tight text-white"
                        >
                            YNE
                        </h2>

                        <p class="text-sm font-medium text-white/80">AlmaSys</p>
                    </div>
                </div>

                <!-- Texto principal -->
                <div class="max-w-xl">
                    <!-- Badge -->
                    <div
                        class="mb-6 inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/15 px-4 py-2 text-xs font-semibold tracking-wider text-white backdrop-blur-md"
                    >
                        <span
                            class="h-2 w-2 rounded-full bg-cyan-300 shadow-[0_0_10px_rgba(103,232,249,0.9)]"
                        ></span>

                        SISTEMA DE GESTIÓN
                    </div>

                    <h1
                        class="text-5xl font-extrabold leading-[1.05] tracking-tight text-white xl:text-6xl"
                    >
                        Control total de
                        <br />

                        <span class="text-white"> tu inventario. </span>
                    </h1>

                    <p
                        class="mt-7 max-w-lg text-base leading-7 text-white/80 xl:text-lg"
                    >
                        Gestiona entradas, salidas y existencias en tiempo real
                        con tecnología de automatización industrial.
                    </p>
                </div>

                <!-- Estadísticas -->
                <div class="grid max-w-xl grid-cols-3 gap-5">
                    <!-- Artículos -->
                    <div class="flex items-center gap-3 text-white">
                        <div
                            class="flex h-11 w-11 items-center justify-center rounded-xl border border-white/20 bg-white/10 backdrop-blur"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"
                                />
                            </svg>
                        </div>

                        <div>
                            <p class="text-2xl font-bold">
                                Artículos registrados
                            </p>
                        </div>
                    </div>

                    <!-- Categorías -->
                    <div class="flex items-center gap-3 text-white">
                        <div
                            class="flex h-11 w-11 items-center justify-center rounded-xl border border-white/20 bg-white/10 backdrop-blur"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8zM22 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"
                                />
                            </svg>
                        </div>

                        <div>
                            <p class="text-2xl font-bold">2</p>

                            <p class="text-xs text-white/70">
                                Categorías activas
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- =====================================================
             PANEL DERECHO
        ====================================================== -->
        <section
            class="relative flex min-h-screen flex-1 items-center justify-center overflow-hidden px-5 py-10 sm:px-8"
        >
            <!-- Decoraciones -->
            <div
                class="absolute -right-32 -top-32 h-80 w-80 rounded-full bg-violet-200/50 blur-3xl"
            ></div>

            <div
                class="absolute -bottom-32 -left-32 h-80 w-80 rounded-full bg-blue-200/40 blur-3xl"
            ></div>

            <!-- Formulario -->
            <div class="relative z-10 w-full max-w-xl">
                <div
                    class="rounded-[28px] border border-white/80 bg-white/90 p-7 shadow-[0_25px_80px_rgba(79,70,229,0.12)] backdrop-blur-xl sm:p-10"
                >
                    <!-- Logo móvil -->
                    <div class="mb-7 flex justify-center lg:hidden">
                        <div
                            class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-500 to-violet-600 text-xl font-bold text-white shadow-lg shadow-violet-200"
                        >
                            Y
                        </div>
                    </div>

                    <!-- Encabezado -->
                    <div class="mb-9 text-center">
                        <div
                            class="mx-auto mb-6 hidden h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-500 to-violet-600 text-2xl font-bold text-white shadow-lg shadow-violet-200 sm:flex"
                        >
                            Y
                        </div>

                        <p
                            class="mb-3 text-xs font-semibold uppercase tracking-[0.25em] text-violet-500"
                        >
                            Acceso de empleado
                        </p>

                        <h1
                            class="text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl"
                        >
                            Bienvenido
                        </h1>

                        <p class="mt-3 text-sm text-slate-400">
                            Ingresa tus datos para continuar
                        </p>
                    </div>

                    <!-- Formulario -->
                    <form @submit.prevent="iniciarSesion" class="space-y-6">
                        <!-- Número de empleado -->
                        <div>
                            <label
                                for="no_empleado"
                                class="mb-2.5 block text-sm font-semibold text-slate-700"
                            >
                                Número de nómina
                            </label>

                            <div class="relative">
                                <!-- Icono -->
                                <div
                                    class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="1.7"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0z"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M4 21a8 8 0 0116 0"
                                        />
                                    </svg>
                                </div>

                                <input
                                    id="no_empleado"
                                    v-model="form.no_empleado"
                                    type="text"
                                    placeholder="Ingresa tu número de nómina"
                                    autocomplete="username"
                                    class="h-14 w-full rounded-xl border border-slate-200 bg-slate-50/70 pl-12 pr-4 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-violet-400 focus:bg-white focus:ring-4 focus:ring-violet-100"
                                />
                            </div>
                        </div>

                        <!-- Contraseña -->
                        <div>
                            <label
                                for="password"
                                class="mb-2.5 block text-sm font-semibold text-slate-700"
                            >
                                Contraseña
                            </label>

                            <div class="relative">
                                <!-- Candado -->
                                <div
                                    class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="1.7"
                                    >
                                        <rect
                                            width="14"
                                            height="12"
                                            x="5"
                                            y="9"
                                            rx="2"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M8 9V7a4 4 0 018 0v2"
                                        />
                                    </svg>
                                </div>

                                <input
                                    id="password"
                                    v-model="form.password"
                                    :type="
                                        mostrarPassword ? 'text' : 'password'
                                    "
                                    placeholder="Ingresa tu contraseña"
                                    autocomplete="current-password"
                                    class="h-14 w-full rounded-xl border border-slate-200 bg-slate-50/70 pl-12 pr-12 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-violet-400 focus:bg-white focus:ring-4 focus:ring-violet-100"
                                />

                                <!-- Mostrar contraseña -->
                                <button
                                    type="button"
                                    @click="mostrarPassword = !mostrarPassword"
                                    class="absolute right-0 top-0 flex h-14 w-12 items-center justify-center text-slate-400 transition hover:text-violet-600"
                                    :aria-label="
                                        mostrarPassword
                                            ? 'Ocultar contraseña'
                                            : 'Mostrar contraseña'
                                    "
                                >
                                    <svg
                                        v-if="!mostrarPassword"
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="1.7"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6z"
                                        />

                                        <circle cx="12" cy="12" r="2.5" />
                                    </svg>

                                    <svg
                                        v-else
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="1.7"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M3 3l18 18"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M10.5 6.2A9.7 9.7 0 0112 6c6 0 9.5 6 9.5 6a16 16 0 01-3.1 3.8M6.2 6.2C3.7 8.1 2.5 12 2.5 12s3.5 6 9.5 6c1.4 0 2.7-.3 3.8-.8"
                                        />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Recuperar contraseña -->
                        <div class="flex justify-end">
                            <button
                                type="button"
                                class="text-sm font-medium text-violet-600 transition hover:text-violet-800 hover:underline"
                            >
                                ¿Olvidaste tu contraseña?
                            </button>
                        </div>

                        <!-- Botón -->
                        <button
                            type="submit"
                            :disabled="cargando"
                            class="group relative flex h-14 w-full items-center justify-center gap-3 overflow-hidden rounded-xl bg-gradient-to-r from-blue-500 via-indigo-500 to-violet-600 text-sm font-bold text-white shadow-lg shadow-violet-200 transition duration-300 hover:-translate-y-0.5 hover:shadow-xl hover:shadow-violet-300 disabled:cursor-not-allowed disabled:opacity-60"
                        >
                            <span
                                v-if="cargando"
                                class="h-5 w-5 animate-spin rounded-full border-2 border-white/30 border-t-white"
                            ></span>

                            <span v-if="cargando"> Iniciando sesión... </span>

                            <template v-else>
                                <span> Iniciar sesión </span>

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 transition-transform duration-300 group-hover:translate-x-1"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M5 12h14M13 6l6 6-6 6"
                                    />
                                </svg>
                            </template>
                        </button>
                    </form>

                    <!-- Separador -->
                    <div class="my-8 flex items-center gap-4">
                        <div class="h-px flex-1 bg-slate-200"></div>

                        <span class="text-xs text-slate-400">
                            ACCESO SEGURO
                        </span>

                        <div class="h-px flex-1 bg-slate-200"></div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="mt-6 text-center">
                    <p class="text-xs text-slate-400">
                        © 2026 YNE Automatización · Proyecto
                    </p>
                </div>
            </div>
        </section>
    </div>
</template>
