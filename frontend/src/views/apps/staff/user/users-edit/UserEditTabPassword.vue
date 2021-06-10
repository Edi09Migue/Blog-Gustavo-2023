<template>
    <validation-observer
        #default="{ handleSubmit }"
        v-if="userData"
        ref="refFormObserver"
    >
        <!-- User Info: Input Fields -->
        <b-form
            @submit.prevent="handleSubmit(onSubmit)"
            @reset.prevent="resetForm"
        >
            <!-- danger -->
            <b-alert variant="danger" show v-if="errorServer">
                <h4 class="alert-heading">
                    Error
                </h4>
                <div class="alert-body">
                    <span>{{ errorServer }}</span>
                </div>
            </b-alert>
            <b-row>
                <b-col cols="12" md="6" lg="6">
                    <validation-provider
                        #default="validationContext"
                        name="Name"
                        rules="required|max:255"
                    >
                        <b-form-group label="Contraseña" label-for="password">
                            <b-input-group class="input-group-merge">
                                <b-input-group-prepend is-text>
                                    <feather-icon size="16" icon="LockIcon" />
                                </b-input-group-prepend>
                                <b-form-input
                                    id="password"
                                    v-model="password"
                                    type="password"
                                    required
                                    :state="
                                        getValidationState(validationContext)
                                    "
                                />
                            </b-input-group>
                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>
                </b-col>

                <b-col cols="12" md="6" lg="6">
                    <b-form-group
                        label="Repetir Contraseña"
                        label-for="confirm_password"
                    >
                        <b-input-group class="input-group-merge">
                            <b-input-group-prepend is-text>
                                <feather-icon size="16" icon="LockIcon" />
                            </b-input-group-prepend>
                            <b-form-input
                                id="confirm_password"
                                v-model="confirm_password"
                                type="password"
                                required
                            />
                        </b-input-group>
                    </b-form-group>
                </b-col>

                <b-col class="mt-2">
                    <b-button
                        variant="primary"
                        class="mb-1 mb-sm-0 mr-0 mr-sm-1"
                        type="submit"
                        :block="
                            $store.getters['app/currentBreakPoint'] === 'xs'
                        "
                    >
                        {{ $t("Save Changes") }}
                    </b-button>
                    <b-button
                        variant="outline-secondary"
                        :block="
                            $store.getters['app/currentBreakPoint'] === 'xs'
                        "
                    >
                        {{ $t("Reset") }}
                    </b-button>
                </b-col>
            </b-row>
        </b-form>
    </validation-observer>
</template>

<script>
import {
    BRow,
    BCol,
    BForm,
    BFormGroup,
    BFormInput,
    BButton,
    BInputGroup,
    BInputGroupPrepend,
    BFormInvalidFeedback,
    BAlert
} from "bootstrap-vue";

import store from "@/store";
import { ref } from "@vue/composition-api";
import { useRouter } from "@core/utils/utils";

import { ValidationProvider, ValidationObserver } from "vee-validate";
import formValidation from "@core/comp-functions/forms/form-validation";

//Toasts
import { useToast } from "vue-toastification/composition";
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";

export default {
    components: {
        BRow,
        BCol,
        BForm,
        BFormGroup,
        BFormInput,
        BButton,
        BInputGroup,
        BInputGroupPrepend,
        BFormInvalidFeedback,
        //Validation
        ValidationProvider,
        ValidationObserver,
        BAlert
    },
    props: {
        userData: {
            type: Object,
            required: true
        }
    },
    setup(props) {
        const { route, router } = useRouter();
        const toast = useToast();

        const password = ref(null);
        const confirm_password = ref(null);
        const errorServer = ref(null);

        const onSubmit = () => {
            store
                .dispatch("app-user/updatePassword", {
                    id: props.userData.id,
                    password: password.value,
                    password_confirmation: confirm_password.value
                })
                .then(response => {
                    if (response.data.status) {
                        router
                            .replace({ name: "apps-users-list" })
                            .then(() => {
                                toast({
                                    component: ToastificationContent,
                                    position: "top-right",
                                    props: {
                                        title: `Actualizado`,
                                        icon: "CoffeeIcon",
                                        variant: "success",
                                        text: `Usuario ${response.data.data.name}. Actualizdo correctamente!`
                                    }
                                });
                            })
                            .catch(error => {
                                console.log("error");
                                console.log(error);
                                this.$refs.loginForm.setErrors(
                                    error.response.data.error
                                );
                            });
                    } else {
                        errorServer.value = response.data.msg;
                    }
                });
        };

        const { refFormObserver, getValidationState } = formValidation();

        return {
            password,
            confirm_password,
            onSubmit,
            refFormObserver,
            getValidationState,
            errorServer
        };
    }
};
</script>

<style></style>
