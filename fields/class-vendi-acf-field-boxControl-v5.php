<?php

class Vendi_ACF_Field_Box_Control extends acf_field
{
    public function __construct(array $settings)
    {
        // Name.
        $this->name = 'vendi-acf-box-control';

        // Label.
        $this->label = esc_html__('Box Control', 'vendi-acf-box-control');

        // Category.
        $this->category = 'layout';

        // Defaults.
        $this->defaults = [
            'unit' => 'rem',
        ];

        // Internationalization.
        $this->l10n = [];

        // Units.
        $this->units = [
            'px' => 'px',
            '%' => '%',
            'in' => 'in',
            'cm' => 'cm',
            'mm' => 'mm',
            'em' => 'em',
            'ex' => 'ex',
            'pt' => 'pt',
            'pc' => 'pc',
            'rem' => 'rem',
        ];

        $this->sizes = [
            '' => 'Default',
            'xx-small' => 'XX-Small',
            'x-small' => 'X-Small',
            'small' => 'Small',
            'medium' => 'Medium',
            'large' => 'Large',
            'x-large' => 'X-Large',
            'xx-large' => 'XX-Large',
            'custom' => 'Custom',
        ];

        $this->sides = [
            'block' => 'Block ↕',
            'inline' => 'Inline ↔',
        ];

        $this->devices = [
            'desktop' => 'Desktop',
            'tablet' => 'Tablet',
            'mobile' => 'Mobile',
        ];

        // Settings.
        $this->settings = $settings;

        $this->env = array(
            'url' => site_url(str_replace(ABSPATH, '', __DIR__)), // URL to the acf-FIELD-NAME directory.
            'version' => '1.0.0', // Replace this with your theme or plugin version constant.
        );

//        $this->preview_image

        // Call parent constructor.
        parent::__construct();
    }

    public function render_field_settings(array $field): void
    {
        acf_render_field_setting(
            $field,
            [
                'label' => esc_html__('Default Unit', 'vendi-acf-box-control'),
                'instructions' => '',
                'type' => 'radio',
                'name' => 'unit',
                'choices' => $this->units,
                'layout' => 'horizontal',
            ]
        );

        acf_render_field_setting(
            $field,
            [
                'label' => esc_html__('Units', 'vendi-acf-box-control'),
                'instructions' => '',
                'type' => 'textarea',
                'name' => 'units',
                'value' => implode("\n", $this->units),
            ]
        );
    }

    /**
     * Render field.
     *
     * @param array $field Field details.
     * @since 1.0.0
     *
     */
    public function render_field(array $field): void
    {
        ?>
        <div class="flow-control-groups">
            <?php foreach ($this->sides as $sideKey => $side): ?>
                <fieldset class="flow-control-group" data-role="flow-control-group">
                    <legend><?php esc_html_e($side); ?></legend>

                    <?php $this->renderPresets(field: $field, sideKey: $sideKey) ?>

                    <div class="divider"></div>

                    <div class="custom-container" data-role="custom-settings-container">

                        <?php $this->renderDimension(field: $field, dimension: 'Start', dimensionKey: 'start', sideKey: $sideKey) ?>

                        <?php $this->renderLink(field: $field) ?>

                        <?php $this->renderDimension(field: $field, dimension: 'End', dimensionKey: 'end', sideKey: $sideKey) ?>
                    </div>

                </fieldset>
            <?php endforeach; ?>
        </div>
        <?php
    }

    public function input_admin_enqueue_scripts(): void
    {
        $url = $this->settings['url'];

        $version = $this->settings['version'];

        wp_enqueue_script($this->name, "{$url}assets/input.js", ['acf-input'], $version);
        wp_enqueue_style($this->name, "{$url}assets/input.css", ['acf-input'], $version);
    }

    private function renderLink($field): void
    {
        ?>
        <div class="link" data-role="link-button-container">
            <input type="hidden" name="block-link-status" value="linked" data-role="link-status-field"/>
            <button data-role="link-button">
                <svg data-link-status="linked" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 60" fill="currentColor" data-role="link">
                    <path d="M26 22H12c-4.4 0-8 3.6-8 8s3.6 8 8 8h14v4H12C5.4 42 0 36.6 0 30s5.4-12 12-12h14v4Zm8 0h14c4.4 0 8 3.6 8 8s-3.6 8-8 8H34v4h14c6.6 0 12-5.4 12-12s-5.4-12-12-12H34v4Z" class="cls-1"/>
                    <path d="M20 28c-1.1 0-2 .9-2 2s.9 2 2 2h20c1.1 0 2-.9 2-2s-.9-2-2-2H20Z"/>
                </svg>
                <svg class="hidden" data-link-status="unlinked" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 60" fill="currentColor">
                    <path d="M32 2c0-1.1-.9-2-2-2s-2 .9-2 2v6c0 1.1.9 2 2 2s2-.9 2-2V2ZM21.4 6.6c-.8-.8-2-.8-2.8 0-.8.8-.8 2 0 2.8l4.2 4.2c.8.8 2 .8 2.8 0 .8-.8.8-2 0-2.8l-4.2-4.2ZM41.5 9.4c.8-.8.8-2 0-2.8-.8-.8-2-.8-2.8 0l-4.2 4.2c-.8.8-.8 2 0 2.8.8.8 2 .8 2.8 0l4.2-4.2ZM25.7 49.2c.8-.8.8-2 0-2.8-.8-.8-2-.8-2.8 0l-4.2 4.2c-.8.8-.8 2 0 2.8.8.8 2 .8 2.8 0l4.2-4.2ZM37.3 46.4c-.8-.8-2-.8-2.8 0-.8.8-.8 2 0 2.8l4.2 4.2c.8.8 2 .8 2.8 0 .8-.8.8-2 0-2.8l-4.2-4.2ZM32 52c0-1.1-.9-2-2-2s-2 .9-2 2v6c0 1.1.9 2 2 2s2-.9 2-2v-6ZM26 22H12c-4.4 0-8 3.6-8 8s3.6 8 8 8h14v4H12C5.4 42 0 36.6 0 30s5.4-12 12-12h14v4ZM34 22h14c4.4 0 8 3.6 8 8s-3.6 8-8 8H34v4h14c6.6 0 12-5.4 12-12s-5.4-12-12-12H34v4Z"/>
                </svg>
            </button>
        </div>
        <?php
    }

    private function renderPresets($field, $sideKey): void
    {
        $sizes = $this->sizes;
        $localSize = $field['value'][$this->name][$sideKey]['preset'] ?? 'default';
        ?>
        <label data-role="preset" class="preset-container">
            <span>Presets</span>
            <select class="presets" name="<?php esc_attr_e($this->getFieldName($field, $sideKey, 'preset')); ?>">
                <?php foreach ($sizes as $sizeKey => $size): ?>
                    <option
                            value="<?php esc_attr_e($sizeKey); ?>"
                        <?php if ($sizeKey === $localSize): ?>
                            selected
                        <?php endif; ?>
                    ><?php esc_html_e($size); ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <?php
    }

    private function getFieldName($field, ...$stuff): string
    {
        return $field['name'].'['.$this->name.']['.implode('][', $stuff).']';
    }

    private function renderDimension($field, $dimension, $dimensionKey, $sideKey): void
    {
        $units = null;
        if (isset($field['units'])) {
            $units = explode("\n", $field['units']);
        }

        if (!$units) {
            $units = $this->units;
        }

        $localValue = $field['value'][$this->name][$sideKey][$dimensionKey]['value'] ?? 4;
        $localUnit = $field['value'][$this->name][$sideKey][$dimensionKey]['unit'] ?? $this->defaults['unit'];
        ?>
        <label data-role="side" class="side-container">
            <span><?php esc_html_e($dimension); ?></span>
            <span class="number-and-unit-picker">
            <input
                    type="number"
                    value="<?php esc_attr_e($localValue); ?>"
                    name="<?php esc_attr_e($this->getFieldName($field, $sideKey, $dimensionKey, 'value')); ?>">
            <select name="<?php esc_attr_e($this->getFieldName($field, $sideKey, $dimensionKey, 'unit')); ?>">
                <?php foreach ($units as $unit): ?>
                    <option
                            value="<?php esc_attr_e(trim($unit)); ?>"
                        <?php if ($unit === $localUnit): ?>
                            selected
                        <?php endif; ?>
                    ><?php esc_html_e($unit); ?></option>
                <?php endforeach; ?>
            </select>
        </span>
        </label>
        <?php
    }
}
