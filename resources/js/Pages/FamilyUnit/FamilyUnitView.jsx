import { usePage } from "@inertiajs/react";
import AppLayout from "../../Layouts/AppLayout";
import { Button, InputAdornment, TextField } from "@mui/material";
import { DataGrid } from "@mui/x-data-grid";

export default function FamilyUnitView() {
    const { familyUnit } = usePage().props;

    const columns = [
        { field: "id", headerName: "ID", width: 70 },
        {
            field: "fullName",
            headerName: "Full name",
            sortable: false,
            valueGetter: (params) =>
                `${params.row.first_name || ""} ${params.row.last_name || ""}`,
            width: 200,
        },
        {
            field: "nic",
            headerName: "NIC",
            width: 150,
        },
        {
            field: "email",
            headerName: "Email",
            width: 250,
        },
        {
            field: "phone",
            headerName: "Phone",
            width: 150,
        },
    ];

    return (
        <AppLayout title="Family Unit">
            <div className="grid-container">
                <div className="grid-toolbar">
                    <h2 className="grid-title">Members</h2>
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

                        <Button variant="contained">Add</Button>
                    </div>
                </div>

                <DataGrid
                    style={{ padding: 20 }}
                    className="bg-white"
                    rows={familyUnit.members}
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
