/* jshint esversion: 6, esversion: 6 */
/*global window */
(function (window) {

    const

        setFlowControlGroupCustomSettingsVisibility = (flowControlGroup) => {
            const select = flowControlGroup.querySelector('select');

            flowControlGroup.classList.toggle('custom-values', select.options[select.selectedIndex].value !== 'custom');
        },

        setFlowControlGroup = (flowControlGroup) => {

            const customSettingsContainer = flowControlGroup.querySelector('[data-role~=custom-settings-container]');
            const numberFields = customSettingsContainer.querySelectorAll('input[type=number]');
            const unitFields = customSettingsContainer.querySelectorAll('select');
            const linkButton = flowControlGroup.querySelector('[data-role~=link-button-container]');
            const linkStatusField = flowControlGroup.querySelector('[data-role~=link-button-container] [data-role~=link-status-field]');
            const svgs = flowControlGroup.querySelectorAll('[data-role~=link-button-container] [data-role~=link-button] [data-link-status]');

            setFlowControlGroupCustomSettingsVisibility(flowControlGroup);

            numberFields
                .forEach(
                    (number) => {
                        number
                            .addEventListener(
                                'change',
                                () => {
                                    if (linkStatusField.value === 'linked') {
                                        numberFields
                                            .forEach(
                                                (subNumber) => {
                                                    if (subNumber === number) {
                                                        return;
                                                    }
                                                    subNumber.value = number.value;
                                                }
                                            )
                                        ;
                                    }
                                }
                            )
                        ;
                    }
                )
            ;

            unitFields
                .forEach(
                    (unit) => {
                        unit
                            .addEventListener(
                                'change',
                                () => {
                                    if (linkStatusField.value === 'linked') {
                                        unitFields
                                            .forEach(
                                                (subUnit) => {
                                                    if (subUnit === unit) {
                                                        return;
                                                    }
                                                    subUnit.value = unit.value;
                                                }
                                            )
                                        ;
                                    }
                                }
                            )
                        ;
                    }
                )
            ;

            flowControlGroup
                .querySelector('select')
                .addEventListener(
                    'change',
                    () => {
                        setFlowControlGroupCustomSettingsVisibility(flowControlGroup);
                    }
                )
            ;

            linkButton
                .addEventListener(
                    'click',
                    (evt) => {
                        evt.preventDefault();
                        const newStatus = linkStatusField.value === 'linked' ? 'unlinked' : 'linked';
                        linkStatusField.value = newStatus;
                        svgs
                            .forEach(
                                (svg) => {
                                    svg.classList.toggle('hidden', svg.getAttribute('data-link-status') !== newStatus);
                                }
                            )
                        ;
                    }
                )
            ;
        },

        run = (fields) => {
            // console.log(fields.toArray());
            // debugger;
            fields
                .toArray()
                .forEach(
                    (field) => {
                        field
                            .querySelectorAll('[data-role~=flow-control-group]')
                            .forEach(
                                (flowControlGroup) => {
                                    setFlowControlGroup(flowControlGroup);
                                }
                            )
                        ;
                    }
                )
            ;
        },

        init = () => {
            if (typeof window.acf !== 'undefined') {
                const acf = window.acf;

                if (typeof acf.add_action !== 'undefined') {
                    acf.add_action('ready_field/type=dimensions', run);
                    acf.add_action('append_field/type=dimensions', run);
                }
            }
        }
    ;

    // Boot
    init();
}(window));