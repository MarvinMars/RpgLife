<script src="https://d3js.org/d3.v7.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/d3-org-chart@2.6.0"></script>
<script src="https://cdn.jsdelivr.net/npm/d3-flextree@2.1.2/build/d3-flextree.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet"/>

<div style="width: 100%; height: 100vh;">
    <div class="chart-container"></div>
</div>

<script>
    var data = JSON.parse('@json($this->getViewData())');

    var root = [{
        name: 'Root',
        id: 0,
        parentId: null
    }]

    var chart = new d3.OrgChart()
        .container('.chart-container')
        .data([...data, ...root])
        .nodeHeight((d) => 85)
        .nodeWidth((d) => 220)
        .childrenMargin((d) => 50)
        .compactMarginBetween((d) => 25)
        .compactMarginPair((d) => 50)
        .neightbourMargin((a, b) => 25)
        .siblingsMargin((d) => 25)
        .buttonContent(({ node, state }) => {
            return `<div style="px;color:#716E7B;border-radius:5px;padding:4px;font-size:10px;margin:auto auto;background-color:white;border: 1px solid #E4E2E9"> <span style="font-size:9px">${
                node.children
                    ? `<i class="fas fa-angle-up"></i>`
                    : `<i class="fas fa-angle-down"></i>`
            }</span> ${node.data._directSubordinates}  </div>`;
        })
        .linkUpdate(function (d, i, arr) {
            d3.select(this)
                .attr('stroke', (d) =>
                    d.data._upToTheRootHighlighted ? '#152785' : '#E4E2E9'
                )
                .attr('stroke-width', (d) =>
                    d.data._upToTheRootHighlighted ? 5 : 1
                );

            if (d.data._upToTheRootHighlighted) {
                d3.select(this).raise();
            }
        })
        .nodeContent(function (d, i, arr, state) {
            const color = '#FFFFFF';
            return `
            <div style="
                background-color:${color};
                position:absolute;
                width:${d.width}px;
                height:${d.height}px;
                border-radius:10px;
                border: 1px solid #E4E2E9
                ">
              <div style="
                    font-size:15px;
                    color:#08011E;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    height: 100%;
              ">${d.data.name}</div>
           </div>
  `;
        })
        .render();
</script>