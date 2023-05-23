import { React } from "react";
import { usePage } from "@inertiajs/react";
import AppLayout from "../../Layouts/AppLayout";
import { DataGrid } from "@mui/x-data-grid";
import { TextField, InputAdornment, Button } from "@mui/material";

export default function FamilyUnitIndex() {
    const { familyUnits } = usePage().props;

    const columns = [
        { field: "id", headerName: "ID", width: 70 },
        {
            field: "primary_member_id",
            headerName: "Primary Member ID",
            width: 130,
        },
    ];

    return (
        <AppLayout title="Family Units">
            <div className="grid-container">
                <div className="grid-toolbar">
                    <h2 className="grid-title">All Family Units</h2>
                    <div className="grid-actions d-flex gap-3">
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

                        <Button variant="contained">Create</Button>
                    </div>
                </div>

                <DataGrid
                    style={{ padding: 20 }}
                    className="bg-white"
                    rows={familyUnits}
                    columns={columns}
                    initialState={{
                        pagination: {
                            paginationModel: { page: 0, pageSize: 5 },
                        },
                    }}
                    pageSizeOptions={[5, 10]}
                />
            </div>
        </AppLayout>
    );
}
