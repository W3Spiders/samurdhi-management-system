import { usePage } from "@inertiajs/react";
import AppLayout from "../../Layouts/AppLayout";
import { Button, InputAdornment, TextField } from "@mui/material";
import { DataGrid } from "@mui/x-data-grid";
import { router } from "@inertiajs/react";

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
            width: 200,
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
        { field: "marital_status", headerName: "Marital Status", width: 120 },
        {
            field: "gender",
            headerName: "Gender",
            valueGetter: (params) =>
                params.row.gender == "m" ? "Male" : "Female",
            width: 70,
        },
        {
            field: "has_income",
            headerName: "Has Income Method",
            valueGetter: (params) =>
                params.row.has_income == 0 ? "No" : "Yes",
            width: 150,
        },
    ];

    const onAddMemberClick = () => {
        router.visit(route("familyUnit.createMember", { id: familyUnit.id }));
    };

    return (
        <AppLayout title="Family Unit">
            <div className="grid-container">
                <div className="grid-toolbar">
                    <h2 className="grid-title">Members</h2>
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

                        <div
                            className="d-flex align-items-end"
                            style={{ display: "flex", alignItems: "end" }}
                        >
                            <Button
                                variant="contained"
                                onClick={() => onAddMemberClick()}
                            >
                                Add
                            </Button>
                        </div>
                    </div>
                </div>

                <DataGrid
                    style={{ padding: 20, maxWidth: "100%" }}
                    className="bg-white"
                    rows={familyUnit.members}
                    columns={columns}
                    initialState={{
                        pagination: {
                            paginationModel: { page: 0, pageSize: 10 },
                        },
                    }}
                    pageSizeOptions={[10]}
                />
            </div>
        </AppLayout>
    );
}
