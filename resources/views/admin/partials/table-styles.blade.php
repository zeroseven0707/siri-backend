<style>
.orderDatatable_actions { display:flex; gap:8px; list-style:none; padding:0; margin:0; }
.orderDatatable_actions .edit,
.orderDatatable_actions .view,
.orderDatatable_actions .remove {
    width:30px; height:30px; border-radius:50%;
    display:flex; align-items:center; justify-content:center;
    transition:all .3s; border:none; cursor:pointer; text-decoration:none;
}
.orderDatatable_actions .edit  { background:rgba(1,104,250,.1); color:#0168fa; }
.orderDatatable_actions .edit:hover  { background:#0168fa; color:#fff; }
.orderDatatable_actions .view  { background:rgba(1,104,250,.1); color:#0168fa; }
.orderDatatable_actions .view:hover  { background:#0168fa; color:#fff; }
.orderDatatable_actions .remove { background:rgba(232,83,71,.1); color:#e85347; }
.orderDatatable_actions .remove:hover { background:#e85347; color:#fff; }

/* Pagination */
.dm-pagination { list-style:none; padding:0; margin:0; gap:4px; }
.dm-pagination__item .dm-pagination__link {
    display:flex; align-items:center; justify-content:center;
    width:34px; height:34px; border-radius:6px;
    border:1px solid #e3e6ef; color:#5a5f7d;
    font-size:13px; text-decoration:none; transition:all .3s;
}
.dm-pagination__item.active .dm-pagination__link {
    background: linear-gradient(135deg, #EC4899, #A855F7);
    border-color: #EC4899; color:#fff;
}
.dm-pagination__item:not(.disabled):not(.active) .dm-pagination__link:hover {
    background:#EC4899; border-color:#EC4899; color:#fff;
}
.dm-pagination__item.disabled .dm-pagination__link {
    opacity:.5; cursor:not-allowed;
}

/* Loading state */
#table-wrapper.loading { opacity:.5; pointer-events:none; transition:opacity .2s; }
</style>
