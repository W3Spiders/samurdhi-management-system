import { React, useEffect } from "react";
import { usePage } from "@inertiajs/react";
import AppLayout from "../../Layouts/AppLayout";
import { DataGrid } from "@mui/x-data-grid";
import { TextField, InputAdornment, Button } from "@mui/material";
import { router } from "@inertiajs/react";

export default function FamilyUnitIndex() {
    const { familyUnits } = usePage().props;

    const columns = [
        { field: "id", headerName: "ID", width: 70 },
        {
            field: "fullName",
            headerName: "Primary Member",
            sortable: false,
            valueGetter: (params) =>
                `${params.row.primary_member?.first_name || ""} ${
                    params.row.primary_member?.last_name || ""
                }`,
            width: 200,
        },
    ];

    const onRowClick = (familyUnit) => {
        router.visit(route("familyUnit", { id: familyUnit.id }));
    };

    return (
        <AppLayout title="Family Units">
            <div className="grid-container">
                <div className="grid-toolbar">
                    <h2 className="grid-title">All Family Units</h2>
                    <div className="grid-actions">
                        <TextField
                            id="search-text"
                            label="Search"
                            InputProps={{
                                startAdornment: (
                                    <InputAdornment position="start">
                                        <i className="fa-solid fa-magnifying-glass"></i>
                                    </InputAdornment>
                                ),
                            }}
                            variant="filled"
                            size="small"
                        />

                        <div style={{ display: "flex", alignItems: "end" }}>
                            <Button variant="contained">Create</Button>
                        </div>
                    </div>
                </div>

                <DataGrid
                    style={{ padding: 20 }}
                    className="bg-white"
                    rows={familyUnits}
                    columns={columns}
                    initialState={{
                        pagination: {
                            paginationModel: { page: 0, pageSize: 25 },
                        },
                    }}
                    pageSizeOptions={[25, 50, 100]}
                    onRowClick={(e) => onRowClick(e)}
                />
            </div>
        </AppLayout>
    );
}
