Tempo.behavior.create('autocomplete', function(config, statics)
{
    if (!config.options)
    {
        config.options = {};
    }
    if (!config.options.postVar)
    {
        config.options.postVar = config.id;
    }
    if (!config.options.minLength)
    {
        config.options.minLength = 2;
    }

    new Autocompleter.Request.JSON(config.id, config.callback, config.options);
});