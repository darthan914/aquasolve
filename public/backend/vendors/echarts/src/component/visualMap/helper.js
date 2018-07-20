define(function(require) {

    var layout = require('../../util/layout');

    var helper = {

        /**
         * @param {module:echarts/component/visualMap/VisualMapModel} visualMapModel\
         * @param {module:echarts/ExtensionAPI} api
         * @param {Array.<number>} itemSize always [short, long]
         * @return {string} 'left' or 'right' or 'top' or 'bottom'
         */
        getItemAlign: function (visualMapModel, api, itemSize) {
            var modelOption = visualMapModel.option;
            var itemAlign = modelOption.align;

            if (itemAlign != null && itemAlign !== 'auto') {
                return itemAlign;
            }

            // Auto decision align.
            var ecSize = {width: api.getWidth(), height: api.getHeight()};
            var realIndex = modelOption.orient === 'horizontal' ? 1 : 0;

            var paramsSet = [
                ['left', 'right', 'width'],
                ['top', 'bottom', 'height']
            ];
            var reals = paramsSet[realIndex];
            var fakeValue = [0, null, 10];

            var layoutInput = {};
            for (var i = 0; i < 3; i++) {
                layoutInput[paramsSet[1 - realIndex][i]] = fakeValue[i];
                layoutInput[reals[i]] = i === 2 ? itemSize[0] : modelOption[reals[i]];
            }

            var rParam = [['x', 'width', 3], ['y', 'height', 0]][realIndex];
            var rect = layout.getLayoutRect(layoutInput, ecSize, modelOption.padding);

            return reals[
                (rect.margin[rParam[2]] || 0) + rect[rParam[0]] + rect[rParam[1]] * 0.5
                    < ecSize[rParam[1]] * 0.5 ? 0 : 1
            ];
        }
    };

    return helper;
});
