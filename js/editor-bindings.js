// Editor side of the asen/site-option bindings source (values resolved in includes/block-bindings.php).
(function (blocks, fields) {
  "use strict";

  if (!blocks || !blocks.registerBlockBindingsSource || !fields) return;

  const fieldsList = Object.keys(fields).map((key) => ({
    label: fields[key].label,
    type: "string",
    args: { key },
  }));

  blocks.registerBlockBindingsSource({
    name: "asen/site-option",
    getValues({ bindings }) {
      const values = {};
      Object.entries(bindings).forEach(([attribute, binding]) => {
        const field = fields[binding.args?.key];
        values[attribute] = field ? field.values[attribute] : null;
      });
      return values;
    },
    getFieldsList() {
      return fieldsList;
    },
  });
})(window.wp && window.wp.blocks, window.asenSiteOptionBindings);
